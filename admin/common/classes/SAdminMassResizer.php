<?php

/**
 * Description of SAdminResizer
 *
 * @author root
 */
class SAdminMassResizer{
    public $admin   = null;
    public $mngrDB  = null;
    
    public $use_bigger = false; # is resizer must use tne bigger images for resize (else use smaller for better performance)
    
    public $data    = null; # main field data from request
    public $table   = null; # table name
    public $main_fld= null; # mail field (ID) of table
    public $history = null; # save changes to history or not
    public $size_x  = null; # new size X
    public $size_y  = null; # new size Y 
    public $size    = null; # array(0=>size_x, 1=>size_y)
    public $resizer = null; # current resizer array
    public $resizers= null; # all resizers by name
    public $rname   = null; # current resizer name
    
    public $current_size_x = null;
    public $current_size_y = null;
    
    public $errors  = array();
    public $cparams = array();
    public $log     = array();
        
    public $context = array();
    
    protected $template = 'resize.html';
    protected $cache_sizes = array();
    
    /**
     * Resize all pictures in column X from table Y using bigger data from column Z of table Y 
     * @param SAdmin $admin - admin instance
     * @param MngrDB $mngrDB - MngrDB instance, or wiil be used admins' one
     */
    public function __construct(SAdmin $admin, MngrDB $mngrDB=null) {
        $this->admin = $admin;
        $this->mngrDB = !is_null($mngrDB) ? $mngrDB : $admin->mngrDB;
    }
    
    protected function checkPermissions(){
        return is_writeable($this->resizer['path']);
    }
    
    protected function checkSizes(){
        
    }
    
    protected function resize(){
        $this->addLog("Start resize!");
        
        $microtime_main_start = microtime(1);
        
        #get all fields with images
        $fields = array();
        foreach($this->resizers as $resizer){
            foreach(array('field_url', 'field_path') as $field)
                if (!empty($resizer[$field])) $fields[] = mysql_real_escape_string ($resizer[$field]);
        }
        
        if (empty($fields)){
            return $this->addLog ("Cant find fields names.. Break..", 1);
        }
        $fields[] = mysql_real_escape_string($this->main_fld);
        
        #get list of files to resize
        $images_data = $this->mngrDB->mysqlGet("SELECT `".join('`, `', $fields)."` FROM `{$this->table}` WHERE 1");
        
        if (empty($images_data)){
            return $this->addLog("There are nothing to resize (query return empty list). Break.", 1);
        }
        
        $this->addLog("Images to resize: ".count($images_data));
                
        $fake_resizer = $this->resizers[$this->rname];
        $fake_resizer['size'] = $this->size;
        
        foreach($images_data as $image){
            $microtime_image_start = microtime(1);
            
            $logwarn    = false; 
            $current_id = mysql_real_escape_string($image[$this->main_fld]);
            $path       = $this->getImagePath($this->rname, $image);
            $size       = array(0,0);
            $logstr     = " &gt;&gt; [{$current_id}] {$path} ";
            
            if (!file_exists($path)){
                $logstr .= 'Not exists!'; $logwarn = 1;
            }
            else{
                #get image size
                $size = $this->getImageSize($path);
                $logstr .= " [{$size[0]}x{$size[1]}]";
                if ($this->compareSizes($size, $this->size) == 0){
                    $logstr .= ' - Sizes already equals. Skip.';
                    $this->addLog($logstr, $logwarn);
                    continue; # already have good size. skip this image.
                }
            }
            
            # find image for resize
            
            # check each available image
            # found bigger image
            # use them to resize image
            
            $good_resizer  = null; #resizers with bigger  images (sorted from bigger to smaller)
            $bad_resizer   = null; #resizers with smaller images (sorted from bigger to smaller)
            
            foreach(array_keys($this->resizers) as $rname){
                $r_image_path = $this->getImagePath($rname, $image);
                $r_image_size = $this->getImageSize($r_image_path);
                $r_image_cmp  = $this->compareSizes($r_image_size, $this->size);
                
                # for equals images
                if ($r_image_cmp == 0){
                    $good_resizer = $rname;
                    break; #found equals image
                }
                
                #for bigger image
                if ($r_image_cmp > 0){
                    if (is_null($good_resizer)) $good_resizer = array('rname'=>$rname, 'size'=>$r_image_size, 'path'=>$r_image_path);
                    if ($this->use_bigger && $this->compareSizes($r_image_size, $good_resizer['size']) > 0) 
                        $good_resizer = array('rname'=>$rname, 'size'=>$r_image_size, 'path'=>$r_image_path);
                    if (!$this->use_bigger && $this->compareSizes($r_image_size, $good_resizer['size']) < 0) 
                        $good_resizer = array('rname'=>$rname, 'size'=>$r_image_size, 'path'=>$r_image_path);
                }
                
                #for smaller image
                if ($r_image_cmp < 0 && (is_null($bad_resizer)  || $this->compareSizes($r_image_size, $bad_resizer['size'])  > 0)){
                    $bad_resizer  = array('rname'=>$rname, 'size'=>$r_image_size, 'path'=>$r_image_path);
                }
            }
            
            
            $use_path = null;
            if ($good_resizer){
                $logstr .= " found bigger image in `{$good_resizer['rname']}` with [{$good_resizer['size'][0]}x{$good_resizer['size'][1]}]";
                $use_path = $good_resizer['path'];
            }
            else{
                $logstr .= " CANT found bigger image - use smaller in `{$bad_resizer['rname']}` with [{$bad_resizer['size'][0]}x{$bad_resizer['size'][1]}]";
                $use_path = $bad_resizer['path'];
            }
            
            
            $saved = $this->admin->resizer('', $fake_resizer, $use_path);
            
            
            # write data to DB
            $arr = array();
            if (!empty($this->resizer['field_url'])  && !empty($saved['url']))  $arr[$this->resizer['field_url']]  = $saved['url'];
            if (!empty($this->resizer['field_path']) && !empty($saved['path'])) $arr[$this->resizer['field_path']] = $saved['path'];
            
            if ($arr){
                $this->mngrDB->mysqlUpdateArray($this->table, $arr, " `{$this->main_fld}`='{$current_id}' ", 1);
                #write history data
                foreach($arr as $key=>$value){
                    if ($this->history) $this->admin->_saveToHistory($key, 'data', $image[$key], $value, $this->table, $current_id);
                }
            }
            else{
                $logstr .= ' - !Update array is empty!'; $logwarn = 1;
            }
            
            $microtime_image_time = round(microtime(1) - $microtime_image_start, 4);
            $logstr .= " Reized by {$microtime_image_time}";
            
            $this->addLog($logstr, $logwarn);
        }
        
        $microtime_main_time = round(microtime(1) - $microtime_main_start, 4);
        $this->addLog("Done by $microtime_main_time", 1);
    }
    
    protected function getResizer($name=false){
        if ($name === false) $name = $this->rname;
        foreach($this->data['values']['resizer'] as $resizer){
            if ($resizer['resizer_name'] == $name) return $resizer;
        }
        return array();
    }
    
    protected function getImagePath($rname, $image_data){
        return !empty($image_data[$this->resizers[$rname]['field_path']]) 
               ? $image_data[$this->resizers[$rname]['field_path']] 
               : $this->pathJoin($_SERVER['DOCUMENT_ROOT'], $image_data[$this->resizers[$rname]['field_url']]);
    }
    
    protected function getImageSize($image_path){
        $result = null;
        if (array_key_exists($image_path, $this->cache_sizes)) $result = $this->cache_sizes[$image_path];
        else @$result = $this->cache_sizes[$image_path] = getimagesize($image_path);
        return $result ? array($result[0], $result[1]) : array(0, 0);
    }
    
    
    protected function compareSizes($size1, $size2){
        #print_r(sprintf("%sx%s - %sx%s\n", $size1[0], $size1[1], $size2[0], $size2[1]));
        if ($size1[0] > $size2[0] || $size1[1] > $size2[1]) return  1; #bigger because one or two edges are bigger (need compress)
        if ($size1[0] < $size2[0] && $size1[1] < $size2[1]) return -1; #smaller because all edges are smaller (need zoom in)
        return 0; # (x1 == x2 && y1 < y2) || (y1 == y2 && x1 < x2) #pictures are equals
    }
    
    protected function compareImages($image1, $image2){
        return $this->compareSizes($this->getImageSize($image1), $this->getImageSize($image2));
    }
    
    protected function isSizeBigger($size1, $size2){
        return $size1[0] >= $size2[0] && $size1[1] >= $size2[1];
    }
    
    protected function isImageBigger($image1, $image2){
        
    }
    
    protected function parseRequest(){
        $table      = $this->getRequestVar('table');
        $size_x     = $this->getRequestVar('sizex');
        $size_y     = $this->getRequestVar('sizey');
        $data       = $this->getRequestVar('data');
        $rname      = $this->getRequestVar('rname');
        $main_fld   = $this->getRequestVar('main_fld');
        $history    = $this->getRequestVar('history', 0);
        $use_bigger = $this->getRequestVar('use_bigger');
        
        if (empty($table) || !$this->mngrDB->mysqlIsTableExists($table))
            $this->addError('Таблица не найдена');
        
        if (empty($size_x) || empty($size_y))
            $this->addError('Размеры заданы неверно');
        
        try {
            $data = unserialize(base64_decode($data));
        } catch (Exception $exc) {
            $data = '';
        }
        
        if (empty($data) || !is_array($data)) 
            $this->addError('Массив параметров передан неверно');
        
        if (empty($rname))
            $this->addError ('Не выбран размер для изменения');

        $this->data       = $data;
        $this->table      = $table;
        $this->size_x     = $size_x;
        $this->size_y     = $size_y;
        $this->size       = array($size_x, $size_y);
        $this->rname      = $rname;
        $this->resizer    = $this->getResizer($rname);
        $this->main_fld   = $main_fld;
        $this->history    = $history;
        $this->use_bigger = $use_bigger;
        
        $this->current_size_x = $this->getRequestVar(0, 0, $this->resizer['size']);
        $this->current_size_y = $this->getRequestVar(1, 0, $this->resizer['size']);
        
        
        $this->resizers= array();
        foreach($this->data['values']['resizer'] as $r) $this->resizers[$r['resizer_name']] = $r;
        
        if ($this->errors)
            return; //exit from check;
        
        if (!$this->isDataFull())
            $this->addError("Передан не полный набор данных");
    }
    
    
    public function loadCParams(){
        @$this->addCParam('Текущий размер', "{$this->current_size_x}x{$this->current_size_y}");
        @$this->addCParam('Изменить размер на', "{$this->size_x}x{$this->size_y}");
        @$this->addCParam('Таблица', $this->table);
        @$this->addCParam('Поле ID в талице', $this->main_fld);
        @$this->addCParam('История', $this->history ? "Включена" : "Выключена");
        @$this->addCParam("Поле для пути", $this->resizer['field_path']);
        @$this->addCParam("Поле для URL",  $this->resizer['field_url']);
        @$this->addCParam("Брать за образец",  $this->use_bigger ? "Наибольшее изображение" : "Наименьшее изображение");
        
    }
    
    public function isDataFull(){
        $params = explode(' ', 'data table main_fld size_x size_y resizer rname current_size_x current_size_y');
        foreach($params as $param)
            if (empty($this->$param)) return false;
        return true;
    }
    
    public function DoAction(){
        //extract data from request
        $this->parseRequest();
        $this->loadCParams();
        if (!$this->checkPermissions())
            $this->addError ("Невозможна запись в директорию ".$this->resizer['path']);
        
        if ($this->isDataFull() && $this->checkPermissions() && !empty($_REQUEST['admin_resizer_start']) && !$this->errors) 
            $this->resize();
        
        $this->render();
    }
    
    
    protected function render(){
        $file = $_SERVER['DOCUMENT_ROOT'].'/'.trim($this->admin->path_to_admin, ' /').'/common/templates/'.$this->template;
        $this->context['title']    = 'Изменение размера картинок';
        $this->context['xform']    = array(
            'table'     => $this->getRequestVar('table'),
            'main_fld'  =>$this->main_fld,
            'history'   =>$this->history,
            'data'      => $this->getRequestVar('data'),
            'rname'     => $this->getRequestVar('rname'),
            'sizex'     => $this->getRequestVar('sizex'),
            'sizey'     => $this->getRequestVar('sizey'),
            'use_bigger'=> $this->use_bigger ? 1 : 0,
        );
        $this->context['errors']   = $this->errors;
        $this->context['cparams']  = $this->cparams;
        $this->context['log']      = $this->log;
        
        echo $this->admin->FillTemplate($file, $this->admin->createContext($this->context));
    }
    
    protected function getRequestVar($name, $default='', &$haystack=null){
        if (is_null($haystack)) $haystack = &$_REQUEST;
        return array_key_exists($name, $haystack) ? $haystack[$name] : $default;
    }
    
    protected function addCParam($name, $value, $warn=false, $overwrite=false){
        if ($overwrite) $this->cparams[$name] = array();
        $this->cparams[$name][] = array('value'=>$value, 'warn'=>$warn);
        
        return $this;
    }
    
    protected function addLog($value, $warn=false){
        $this->log[] = array('value'=>$value, 'warn'=>$warn);
        
        return $this;
    }
    
    protected function addError($error){
        $this->errors[] = $error;
        return $this;
    }
    
    //get full path to admin folder
    private function getFullPath(){
        return $this->pathJoin($_SERVER['DOCUMENT_ROOT'], $this->admin->path_to_admin);
    }
    
    /**
     * Join parts of path to one
     * @param String $_ parts of path
     * @return String Results path
     */
    private function pathJoin($_){
        $trim = '/\\ ';
        $path = '';
        foreach(func_get_args() as $arg){
            $path = rtrim($path, $trim).'/'.ltrim($arg, $trim);
        }
        return $path;
    }
    
    private function listDir($path){
        $dir   = dir($path);
        $dirs  = array();
        $files = array();
        while (false !== ($entry = $dir->read())){
            if ($entry == '.' || $entry == '..') continue;
            $curpath = $this->pathJoin($path, $entry);
            if (is_dir($curpath))
                $dirs[]  = array('name'=>$entry, 'path'=>$curpath, 'type'=>'dir');
            else
                $files[] = array('name'=>$entry, 'path'=>$curpath, 'type'=>'file');
        }
        $ret = array('dirs'=>$dirs, 'files'=>$files);
        return $ret;
    }
}