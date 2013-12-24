<?php
/* ! --       10.08.2011 shevayura       -- !
 *
 * Фильтр. Необходим для работы админки!
 */
class MegaFilterBase{
    public $query = '';
    public $countquery = '';
    public $litequery  = '';
    public $mainquery  = "SELECT calls.id, users.login, partners.partner_name, store.name,
                                store.city, store.address, store.phone, calls.real_date,
                                calls.entered_date, calls.call_result, 
                                calls.comment, calls.externalservice,
                                calls.whynoproduct, store.store_value, partners.manager_id, calls.nic,
                                store.store_status, store.visible, city.region_name, city.yandex_map,
                                store.yandex_map, partners.partner_id, partners.changed_cols, city.city_id,
                                city.changed_cols, store.changed_cols, store.store_id, calls.changed_cols, city.city_name
					FROM calls, users, store, partners, city
					WHERE store.partner_id=partners.partner_id
					AND calls.store_id=store.store_id
					AND calls.user_id=users.user_id
					AND store.city=city.city_name";

    public $mngrDB = Null;
    public $active_filters    = Array();
    public $available_filters = Array();
    public $URL;
    public $fields = Array();
    
    public $link_rest_params = ''; //string with params in url that not a filters

    public $result;
    public $rcount;
    public $start = null;
    public $count = null;
	public $fgroup = '';

    public $def_order = "";
    public $js_was_get = False;
    


    function __construct($mngrDB){
        $this->mngrDB = $mngrDB;
        $this->URL = $this->selfURL();
    }

    function GetOrder($simple=0){

        if ( !isset($_GET['orderby']) )    return $this->def_order ? $this->def_order : '';
        $order = $_GET['orderby'];
        if ( !$this->IsInRequest($order) ) return $this->def_order ? $this->def_order : '';
        if ( !$this->canSort($order) )     return $this->def_order ? $this->def_order : '';
        if ($simple)
            return isset($_GET['desc']) ? $order."&desc=1" : $order;
        
        $order = " ORDER BY `$order`";

        if (isset($_GET['desc'])) $order .= " DESC";
        return $order;
    }

    function GetStart(){
        if ( $this->start !== null)
                return $this->start;
        $start = 0;
        if ( !isset($_GET['start']) ) return $start;
        $start = (int)$_GET['start'];
        $this->start = $start;
        return $start;
    }

    function GetCount(){
        if ( $this->count !== null)
                return $this->count;
        $count = 100;
        if ( !isset($_GET['count']) ) return $count;
        $count = (int)$_GET['count'];
        $this->count = $count;
        return $count;
    }

    function getBlocks(){

    }

    function GetWhere($active = null){
        if ( $active === null )
            $active = $this->active_filters;
        $f = Array();
        $f['_main_'] = array();
        $f['_head_'] = array();
        //array for additional data in filters
        $adds = array();
        foreach($active as $name=>$filter){
            if (!empty($filter['additional_head'])){
                $f['_head_'][] = $filter['additional_head'];
            }
            if ( !array_key_exists('block', $filter) || !$filter['block'] )
                $filter['block'] = "_main_";
            $block = $filter['block'];
            if ( !array_key_exists($block, $f) )
                    $f[$block] = array();
            //check defined clock
            //
            //check additional data for filter
            if (!array_key_exists($block, $adds))
                    $adds[$block] = '';
            $adds[$block] .= !empty($filter['additional']) ? ' '.$filter['additional'].' ' : '';
            //
            if ($filter['type'] == "range_date"){
                if (array_key_exists('min', $filter['active']))
                        $f[$block][] = sprintf("%s>=\"%s\"", $filter['safe_name'], date("Y-m-d", $filter['active']['min']));
                if (array_key_exists('max', $filter['active']))
                        $f[$block][] = sprintf("%s<=\"%s\"", $filter['safe_name'], date("Y-m-d", ($filter['active']['max']+60*60*25)));
                
                continue;
            }
            if ($filter['type'] == 'custom'){
                $fb = array();
                $join = $filter['join'];
                foreach($filter['active'] as $ak=>$av){
                    if (!$av) continue;
                    $fb[] = $filter['values'][$ak]['name'];
                }
                $fb = $fb ? '('.join(" $join ", $fb) . ')' : '';
                if ($fb)
                    $f[$block][] = $fb;
                continue;
            }
            //now other
            if ( !$filter['active'])
                continue;
            if ( count($filter['active']) == 1 ){
                $keys = array_keys($filter['active']);
                $f[$block][] = sprintf("%s='%s'", $filter['safe_name'], mysql_real_escape_string ($keys[0]));
                continue;
            }
            if ( count($filter['active']) > 1 ){
                $keys = array_keys($filter['active']);
                foreach($keys as $k=>$v) {
                    $keys[$k] = mysql_real_escape_string ($v);
                    if ( gettype($keys[$k]) == "string" )
                        $keys[$k] = '"'.$keys[$k].'"';
                }
                $keys =  join(',', $keys);
        //Append this filter to available filters
        //$name = str_replace(".", "_", $name);
                $f[$block][] = sprintf("%s IN (%s)", $filter['safe_name'], $keys);
                continue;
            }
        }

        $f['_head_'] = array_filter($f['_head_']);
        $f['_head_'] = $f['_head_'] ? ', '. join(', ', $f['_head_']) : '';
        
        foreach($f as $k=>$v){
            if ($k == '_head_') continue;
            if ( !$v )
                $f[$k] = "";
            if ( count($v) == 1)
                $f[$k] =  ' AND '.$adds[$k].$v[0];
            if ( count($v)  > 1)
                $f[$k] = ' AND ' .$adds[$k]. join(' AND ', $v);
        }
        
        
        return $f;
    }

    function ConstructQuery($active=null){
        $order = $this->GetOrder();
        $s  = $this->GetStart();
        $c  = $this->GetCount();
        $f  = $this->GetWhere($active);
        $gr = $this->fgroup;

        $limit = " LIMIT $s, $c ";
        
        $litequery    = !empty($this->litequery)  ? $this->litequery  : $this->mainquery;
        $countquery   = !empty($this->countquery) ? $this->countquery : $litequery;

        $q = array();

        $q['full']    = $this->createText($this->mainquery, $f, 1).$f['_main_'].$gr.$order.$limit;
        $q['nolimit'] = $this->createText($this->mainquery, $f, 1).$f['_main_'].$gr.$order;
        $q['onlyeq']  = $this->createText($this->mainquery, $f, 1).$f['_main_'].$gr;
        $q['lite']    = $this->createText($litequery,       $f, 1).$f['_main_'].$gr;
        $q['count']   = $this->createText($countquery,      $f, 1).$f['_main_']; //no group

        return $q;
        
    }
    
    function GetData(){
        //replace this in child 
    }

    private function canSort($name){
        foreach($this->fields as $key=>$value)
            if ( $value['value'] == $name && $value['allow_sort'] )
                return True;
        return False;
    }

    function selfURL() {
	$s = empty($_SERVER["HTTPS"]) ? ''
		: ($_SERVER["HTTPS"] == "on") ? "s"
		: "";
	$protocol = $this->strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
	$port = ($_SERVER["SERVER_PORT"] == "80") ? ""
		: (":".$_SERVER["SERVER_PORT"]);
	return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
    }

    function strleft($s1, $s2) {
	return substr($s1, 0, strpos($s1, $s2));
    }

    public function getLink($filters=null){
        if ($filters === null)
            $filters = $this->active_filters;
        $url = explode('?', $this->URL);
        $url = $url[0];

        $qs = array();
        foreach($filters as $k=>$v){
            $name   = $k;
            $params = '';
            if ($v['type'] == 'range_date'){
                $name1 = '';
                $name2 = '';
                if (array_key_exists('min', $v['active']))
                    $qs[] = $name.'__min='.$v['active']['min'];
                if (array_key_exists('max', $v['active']))
                    $qs[] = $name.'__max='.$v['active']['max'];
                continue;
            }
            $params = join(',', array_map('trim', array_keys($v['active'])));
            $qs[]   = $name.'='.$params;
        }
        if ($this->link_rest_params) $qs[] = $this->link_rest_params; //add other params
        $order = $this->GetOrder(1);
        if ($order && $order !== $this->def_order) $qs[] = "orderby=".$order;
        if ($this->GetCount()) $qs[] = "count="  .$this->GetCount();
        if ($this->GetStart()) $qs[] = "start="  .$this->GetStart();
        
        return $qs ? $url.'?'.join('&', $qs) : $url;

    }

    function killParam($param, $link=''){
        if ( !$link )
            $link = $this->URL;
        $param .= "=";
        if ( strpos($link, $param) !== false ){
            $strA = strpos($link, $param)-1;
            $strB = ( strpos($link, "&", $strA+3) !== false ) ? strpos($link, "&", $strA+3) : null;
            $newLink = substr( $link, 0, $strA );
            if ( $strB )
                $newLink .= substr( $link, $strB );
            if ( strpos($newLink, "&") !== false && strpos($newLink, "?") === false){
                $apos = strpos($newLink, "&");
                $newLink = substr($newLink, 0, $apos) . "?" . substr($newLink, $apos);
            }
            return $newLink;
        }
        return $link;
    }

    public function getAddLink($key, $value, $active=null, $toarray=false){
        if ( $active === null )
            $active = $this->active_filters;

        if ( strpos($key, "__") !== false ){
            $key  = explode("__", $key);
            $vkey = $key[1];
            $key  = $key[0];
        }
        if ( !array_key_exists($key, $active))
                $active[$key] = $this->available_filters[$key];
        if ($this->available_filters[$key]['type'] != "range_date")
            $active[$key]['active'][$value] = 1;
        else{
            $active[$key]['active'][$vkey] = $value;
        }

        return $toarray ? $active : $this->getLink($active);
    }

    public function getDelLink($key, $value, $active=null, $toarray=false){
        if ( $active === null )
            $active = $this->active_filters;
        
        if ( !array_key_exists($key, $active) ){
                return $this->getLink($active);
        }
        unset($active[$key]['active'][$value]);

        if ( !$active[$key]['active'] )
            unset($active[$key]);
        return $toarray ? $active : $this->getLink($active);
    }
    
    public function getAddLinks($arr){
        $active = $this->active_filters;
        foreach ($arr as $key => $val) {
            $val = explode(",", $val);
            foreach( $val as $k => $value)
                $active = $this->getAddLink($key, $value, $active, $toarray=true);
        }
        return $this->getLink($active);
    }

    public function getDelLinks($arr){
        $active = $this->active_filters;
        foreach ($arr as $key => $val) {
            $val = explode(",", $val);
            foreach( $val as $k => $value)
                $active = $this->getDelLink($key, $value, $active, $toarray=true);
        }
        return $this->getLink($active);
    }

    function addToActive($key, $value, $active=null){
        if ( !$active ) $active= $this->active_filters;

        if (strpos($key, "__") !== false){
            $key = explode("__", $key);
            $vkey = $key[1];
            $key  = $key[0];
            if ( !in_array($vkey, Array('max', 'min')) ) return $active;
        }

        if ( !array_key_exists($key, $this->available_filters) )
                return $active;
        if ( !array_key_exists($key, $active) )
                $active[$key] = $this->available_filters[$key];
        if (isset($vkey)){
            //for range_date
            if ( strpos($value, '-') ){
                $date = explode('-', $value);
                $value = mktime(0,0,0,$date[1],$date[2],$date[0]);

            }
            $active[$key]['active'][$vkey] = $value > 0 ? $value : 0;
            return $active;
        }

        //for other

        $values = explode(',', $value);
        foreach($values as $vk=>$vv){
            if ( !array_key_exists($key, $active )){
                $active[$key] = $this->available_filters[$key];
                $active[$key]['active'] = Array();
            }
            $active[$key]['active'][urldecode($vv)] = 1;
        }

        return $active;

    }

    public function getFilters(){
        #Parse filters from URL
        $params = explode('&', $_SERVER['QUERY_STRING']);
        $not_filters = array();
        foreach ($params as $key => $value) {
            //check is filter exists in available filters
            $kkvv = explode('=', $value);
            if  ( count($kkvv) != 2 ) continue;
            $key = $kkvv[0];
            $value = $kkvv[1];
            $this->active_filters = $this->addToActive($key, $value);
            if (!array_key_exists($key, $this->available_filters) && !in_array($key, array('orderby', 'desc', 'count'))) $not_filters[] = $key.'='.$value;
        }
        $not_filters = join("&", $not_filters);
        $this->link_rest_params = $not_filters;
    }

    public function mysql2timestamp($datetime){
       $datedel = strpos($datetime, "-") === false ? "." : "-";
       $val = explode(" ",$datetime);
       $date = explode($datedel,$val[0]);
       $time = explode(":",$val[1]);
       @$mktime = (int)mktime($time[0],$time[1], 0,$date[1],$date[2],$date[0]);
       return $mktime;
    }

    public function AddField($name, $value, $allow_sort=1, $html_param='', $fnc=null, $rehtml=False, $canhide=True, $hidden=False){
        //echo "$value $canhide, $hidden \n";
        //if ( !array_key_exists($name, $this->result) ) return;
        if (!$value) { $canhide=False; $hidden=False; }
        $safe_name = str_replace(array('.'), array('_'), $value);
        $this->fields[$name] = Array('name'=>$name, 'value'=>$value, 'allow_sort'=>$allow_sort,
                                     'html_param'=>$html_param, 'fnc'=>$fnc, 'rehtml'=>$rehtml,
                                     'canhide'=>$canhide, 'hidden'=>$hidden, 'safe_name'=>$safe_name);
    }

    public function createText($template, $dict, $delete=false){
        foreach($dict as $key=>$value){
            @$template = str_replace("{{".$key."}}", $value, $template);
        }
        if ($delete){
            while (true){
                $start = strpos($template, "{{");
                if ( $start === false ) break;

                $end   = strpos($template, "}}", $start);
                if ( $end === false ) break;

                $template = substr($template, 0, $start) . substr($template, $end+2);
            }
        }

        return $template;
    }

    function isActive($key, $value){
        if ( isset($this->active_filters[$key]) ){
            if ( isset($this->active_filters[$key]['active'][$value]) )
                return true;
            if ( $this->active_filters[$key]['type'] == "range_date" )
                return true;
        }
        return false;
    }

    public function getjs(){
        return '<script type="text/javascript">
                    function filter_hide_col(name){
                        th  = document.getElementById("filter_th_"+name);
                        a   = document.getElementById("filter_th_a_"+name);
                        disp = "none";
                        if (a.style.color=="gray"){
                            disp="block";
                            a.style.color="black";
                            a.style.fontSize = "14px";
                        }
                        else{
                            disp="none";
                            a.style.color="gray";
                            a.style.fontSize = "8px";
                        }
                        tds = document.getElementsByClassName("filter_td_div_"+name);
                        for(tdi=0; tdi<tds.length; tdi++){
                            tds[tdi].style.display=disp;
                        }
                    }
                    function makeDate(name, subm){

                        form = document.getElementById("form_"+name);

                        amp = "&";
                        if ( form.elements["clear"].value.search(/\?/i) == -1 ) amp = "?";

                        url  = form.elements["clear"].value;
                        url += amp + name+"__min=" + form.elements[name+"__min"].value;
                        url += "&" + name+"__max=" + form.elements[name+"__max"].value;

                        if ( subm == 1 )
                            document.location=url;
                        }

                    function showhide(name){
                        sp = document.getElementById(name);
                        dv = document.getElementById("available_"+name);
                        dv.style.display;
                        if ( dv.style.display == "none"){
                            sp.innerHTML = "[Cкрыть]";
                            dv.style.display = "";
                        }
                        else{
                            sp.innerHTML = "[Показать]";
                            dv.style.display = "none";
                        }
                    }
                </script>';
        $this->js_was_get = True;
    }

    public function CreateActiveFilterLists(){
        $format = '<br><a href="%s" class="active">%s</a>'."\n";
        $output = "";

        $output .= $this->getjs();

        foreach($this->active_filters as $k=>$v){
            $output .= "<br><br>\n<span style='font-size: 14px;'><b>".$this->available_filters[$k]['label']."</b></span><br>\n";
            if ($this->available_filters[$k]['type'] != "range_date")
                foreach($v['active'] as $kk=>$vv){
                    if ( array_key_exists($kk, $this->available_filters[$k]['values']))
                        $output .= sprintf($format, $this->getDelLink($k, $kk), $this->available_filters[$k]['values'][$kk]['text_value']);
                }
            else{

                $f = '<form id="form_%s">
                        <input type="hidden" name="clear" value="%s" />
                        <table>
                        <tr><td>Начало:</td><td><input type="date" min="%s" max="%s" name="%s__min" value="%s" onkeydown="if (event.keyCode == 13) makeDate(\'%s\', 1)"  style="width: 120px;" /></td></tr>
                        <tr><td>Конец: </td><td><input type="date" min="%s" max="%s" name="%s__max" value="%s" onkeydown="if (event.keyCode == 13) makeDate(\'%s\', 1)"  style="width: 120px;" /></td></tr>

                        <tr><td colspan="2" align="center"><input type="button" name="submit" value="Применить диапазон" onclick="makeDate(\'%s\', 1)" /></td></tr>
                        </table>
                      </form><br>
                      <a href="%s">Удалить этот фильтр</a><br>'."\n";
                $rl = $this->getDelLinks(Array($k=>"min,max"));
                if ( array_key_exists('min', $v['active']) )
                    $min = date('Y-m-d', $v['active']['min']);
                else $min = !empty($v['selected_min']) ? date('Y-m-d', $v['selected_min']) : 0;
                if ( array_key_exists('max', $v['active']) )
                    $max = date('Y-m-d', $v['active']['max']);
                else $max = !empty($v['selected_max']) ? date('Y-m-d', $v['selected_max']) : mktime();
                $xmin = date('Y-m-d', $v['min']);
                $xmax = date('Y-m-d', $v['max']);

                $output .= sprintf($f, $k, $rl, $xmin, $xmax, $k, $min, $k, $xmin, $xmax, $k, $max, $k, $k, $rl);

            }
        }
        $clear = explode('?', $this->URL);
        $clear = $clear[0];
        return $output . '<br><br><br><a href="'.$clear.'">Удалить все фильтры</a><br>'."\n";
    }

    function getFilterCount( $key, $value ){
        $active = $this->active_filters;

        

        if ( !array_key_exists($key, $active))
                $active[$key] = $this->available_filters[$key];
        $active[$key]['active'][$value] = 1;

        $q = $this->ConstructQuery($active);
        
		//var_dump($this->fgroup);


        $count = !empty($this->countquery) ? $q['count'] : "SELECT COUNT(*) AS count FROM (".$q['lite'].") as tab";
        //echo $count; echo " <br/>\n";
		
        $count = $this->mngrDB->mysqlGet($count);
        if ( !$count ) return 0;

        foreach($count[0] as $field) 
            return intval ($field);

        //return (int)$count[0]['count'];
    }

    public function CreateAvailableFilterLists($nocheck=false){
        $format = '<div class="available"><a href="%s">%s</a> <span class="diff">(Σ=%s, %s)</span></div>'."\n";
        if ($nocheck)
            $format = '<br><a href="%s" class="available">%s</a> %s'."\n";
        $output = "";

		//var_dump($this->available_filters);
		
        foreach($this->available_filters as $k=>$v){
            if ( !$v ) continue;
            $fhead = "<br><br>\n<span style='font-size: 14px;'><b>".$this->available_filters[$k]['label']. '</b></span> <span style="font-size:10px; color: gray; border-bottom: 1px dashed gray;" id="'.$k.'" onclick="showhide(this.id)">[%s]</span>';
            $ftext = "";
            $cfilt = 0;
            if ($this->available_filters[$k]['type'] == "range_date"){
                if ( $this->isActive($k, '') ) continue;
                $f = '<form id="form_%s">
                        <input type="hidden" name="clear" value="%s" />
                        <table>
                        <tr><td>Начало:</td><td><input type="date" min="%s" max="%s" name="%s__min" value="%s" onkeydown="if (event.keyCode == 13) makeDate(\'%s\', 1)"  style="width: 120px;"/></td></tr>
                        <tr><td>Конец: </td><td><input type="date" min="%s" max="%s" name="%s__max" value="%s" onkeydown="if (event.keyCode == 13) makeDate(\'%s\', 1)"  style="width: 120px;"/></td></tr>

                        <tr><td colspan="2" align="center"><input type="button" name="submit" value="Изменить диапазон" onclick="makeDate(\'%s\', 1)" /></td><tr>
                        </table>
                      </form><br>'."\n";
                $rl = $this->URL;
                $min = date('Y-m-d', $v['min']);
                $max = date('Y-m-d', $v['max']);
                
                $smin = !empty($v['selected_min']) ? date('Y-m-d', $v['selected_min']) : $min;
                $smax = !empty($v['selected_max']) ? date('Y-m-d', $v['selected_max']) : $max;

                $ftext .= sprintf($f, $k, $rl, $min, $max, $k, $smin, $k, $min, $max ,$k, $smax, $k, $k);
                $cfilt++;
            }
            /**/
            if ($this->available_filters[$k]['type'] == "custom"){
                foreach($v['values'] as $kk=>$vv){
                    if ( $this->isActive($k, $kk) ) continue;
                    $fcount = "";
                    if (!$nocheck){
                        $fcount  = $this->getFilterCount($k, $kk);
                        if (!$fcount) continue;
                        if ($this->active_filters && $fcount == $this->rcount) continue;
                        $sigma  = $fcount+0;
                        $fcount = $fcount - $this->rcount;
                        if ($fcount > 0) $fcount = '+'.$fcount;
                    }
                    $ftext .= sprintf($format, $this->getAddLink($k, $kk), $this->available_filters[$k]['values'][$kk]['text_value'], $sigma, $fcount);
                    $cfilt++;
                }
            }
            if ( in_array($this->available_filters[$k]['type'], array('list', 'list_enum_colored', 'list_enum'))){
                foreach($v['values'] as $kk=>$vv){
                    if ( $this->isActive($k, $kk) ) continue;
                    $fcount = "";
                    if (!$nocheck){
                        $fcount  = $this->getFilterCount($k, $kk);
                        if (!$fcount) continue;
                        if ($this->active_filters && $fcount == $this->rcount) continue;
                        $sigma  = $fcount+0;
                        $fcount = $fcount - $this->rcount;
                        if ($fcount > 0) $fcount = '+'.$fcount;
                    }
                    $ftext .= sprintf($format, $this->getAddLink($k, $kk), $this->available_filters[$k]['values'][$kk]['text_value'], $sigma, $fcount);
                    $cfilt++;
                }
            }
            $sh = array("", "Скрыть");
            if ( $cfilt > $v['hide'] ){
                $sh = array("none", "Показать");
            }
            if ( $cfilt )
                $output .= sprintf ($fhead, $sh[1]) . "<div id='available_{$k}' style='display: {$sh[0]};'>" .$ftext ."</div>\n\n";
        }
        return $output;
    }//!!!!!!!!!!!!!!!!!!!

    public function DrawTable(){
        //draw head
        $table = "<table border=1 class=\"result\">\n%s\n\n%s\n</table>";
        if (!$this->js_was_get) $table = $this->getjs() . "\n\n" . $table;
        $th    = "<tr>";
        foreach($this->fields as $key=>$value){
            $sort = '';
            if ($value['allow_sort']){
                $s1  = $this->killParam('orderby');
                $s1  = $this->killParam("desc", $s1);
                $s1 .= strpos($s1, "?") ? "&" : "?";
                $s1 .= "orderby=".$value['value'];
                $sort = sprintf('<br><span style="white-space: nowrap; font-size:10px;">[<a href="%s">А-Я</a>]  [<a href="%s">Я-А</a>]</span>', $s1, $s1.'&desc=1');
            }
            $th_name = $value['name'];
            if ( strlen($value['name']) && !$value['rehtml'] && !empty($value['canhide']) ){
                $hdn = $value['hidden'] ? "gray; font-size:8px;" : 'black';
                $th_name = sprintf('<a style="color:%s;" id="filter_th_a_%s" href="javascript: filter_hide_col(\'%s\')">%s</a>', $hdn, $value['safe_name'], $value['safe_name'], $th_name);
            }
            $th .= "\n\t<th id=\"filter_th_{$value['safe_name']}\">".$th_name.' '.$sort.'</th>';
        }
        
        $rows = '';
        $i = 0;
        foreach($this->result as $num=>$row){
            $i += 1;
            $rows .= $this->DrawRow($row, $i%2);
        }
        $table .= '</table>';
        return sprintf($table, $th, $rows);
    }//!!!!!!!!!!!!!!!!!!!
    public function DrawRow($row, $i=0){
        $r = "\n".'<tr class="row'.($i+1).'">';
        foreach($this->fields as $key=>$field){
            $data = "#ERROR#";
            if ( $field['fnc'] && function_exists($field['fnc'])){
                $data = call_user_func($field['fnc'], $row, $field);
            }
            else{
                if (array_key_exists($field['value'], $row))
                    $data = $row[$field['value']];
                else{
                    $f = explode('.', $field['value']);
                    $f = $f[count($f)-1];
                    if (!array_key_exists($f, $row))
                        $data = "#NULL#";
                    
                    else
                        $data = $row[$f];
                }
            }
            if ($field['rehtml'])
                $r .= $data;
            else{
                $hdn = $field['canhide'] && $field['hidden'] ? 'none;' : 'block';
                $r .= "\n\t<td {$field['html_param']}><div style=\"display:$hdn;\" class=\"filter_td_div_{$field['safe_name']}\">$data</div></td>";
            }
        }
        $r .= "\n</tr>";
        return $r;
    }//!!!!!!!!!!!!!!!!!!!

    public function GetPosLinks(){
        if (empty($this->start)) $this->start = 0;
        if (empty($this->count)) $this->count = 100;
        $f = '<div class="poslinks">Показано %s начиная с %s. Общее количество: %s. Показывать по [%s]<br>%s  %s</div>';

        $format = '<a href="%s" class="count">%s</a>, ';
        $counts = '';
        $counturl = $this->killParam("count");
        $amp = strpos($counturl, "?") !== false ? "&" : "?";
        $counts .= sprintf($format, $counturl.$amp."count=50",  "50");
        $counts .= sprintf($format, $counturl.$amp."count=100", "100");
        $counts .= sprintf($format, $counturl.$amp."count=200", "200");
        $counts .= sprintf($format, $counturl.$amp."count=300", "300");
        $counts .= sprintf($format, $counturl.$amp."count=500", "500");

        $clear = $this->killParam("start");
        $amp   = strpos($clear, "?") !== false ? "&" : "?";

        if ( $this->start+$this->count < $this->rcount ){
            $n = $this->start+$this->count;
            $n = '<a href="'.$clear.$amp."start=".$n.'">Следующие</a>';
        }
        else
            $n = "";

        $p = '';
        if ($this->start){
            if ( $this->start-$this->count < 0 )
                $p = 0;
            else
                $p = $this->start-$this->count;
            $p = '<a href="'.$clear.$amp."start=".$p.'">Предыдущие</a>  ';
        }

        return sprintf($f, count($this->result), $this->start ? $this->start : 0 , $this->rcount, $counts, $p, $n);

    }      //!!!!!!!!!!!!!!!!!!!

    function IsInRequest($name){
        //Check is this field exists in main query
        if ($this->available_filters[$name]['type'] == 'custom')
                return true;
        $fields = explode("FROM", $this->mainquery);
        $fields = $fields[0];
        $fields = substr($fields, strpos($fields, ' ')+1);
        $fields = explode(',', $fields);
        $fields = array_map('trim', $fields);
        foreach ( $fields as $k=>$v ){
            if ( strpos($v, " AS ") !== false ){
                $v = explode(" AS ", $v);
                $fields[$k] = trim($v[1]);
            }
        }

        return in_array($name, $fields);//check//*/
    }

    public function AddAvailable($label, $name, $type, $query, $value, $text, $hide=100, $block="", $additional="", $additional_head='', $zero=false){
        if ( !in_array($type, Array('list', 'list_enum_colored', 'list_enum', 'range_date', 'custom')) )
                return;//check is this type are available

        if ($zero !== false){
            if (is_array($zero)){
                $zero = $zero;
            }
            if (is_string($zero)){
                $zero = array(0, $zero);
            }
            if (is_int($zero)){
                $zero = array($zero, '--Не указано--');
            }
            if ($zero === true){
                $zero = array(0,'--Не указано--');
            }
        }

        $flt = Array();//Create empty array for this filter type
        $flt['label'] = $label; //Set label
        $flt['type']  = $type;  //Set type
        $flt['hide']  = $hide;
        $flt['block'] = $block ? $block : "_main_";
        $flt['additional'] = $additional ? $additional : "";
        $flt['additional_head'] = $additional_head ? $additional_head : "";
        $flt['safe_name'] = strpos($name, '.') !== false ? $name : '`'.$name.'`';

        if ($type == "custom"){
            $flt['join'] = empty($value['join']) ? "OR" : $value['join'];
            $values = Array();
            $i = 0;
            foreach ($value['variants'] as $k => $v) {
                $values[++$i] = Array('name'=>$v, 'text_value'=>$k);
            }
            $flt['values'] = $values;
        }

        if ($type == "list"){
            $res = $this->mngrDB->mysqlGet($query);//make query to db
            $resv = Array();
            foreach($res as $k=>$v){
                $res[$k]['text_value'] = $this->createText($text, array_merge($v, Array("value"=>$value)));
                $resv[$v[$value]] = $res[$k];
                //append text value for each element
            }
            $flt['values'] = $resv;
            if ($zero) $flt['values'][$zero[0]] = array('id'=>$zero[0], 'text_value'=>$zero[1]);            
        }
        if ($type == "list_enum_colored"){
            $values = Array();
            foreach ($value as $k => $v) {
                $v = explode(',', $v);
                $values[$k] = Array('name'=>$k, 'color1'=>$v[1], 'color2'=>$v[2],
                                  'text_value'=>$this->createText($text, array('value'=>$v[0])));
                //parse coloers and appent text value
            }
            $flt['values'] = $values;
        }
        if ($type == "list_enum"){
            $values = Array();
            foreach ($value as $k => $v) {
                $values[$k] = Array('name'=>$k, 'text_value'=>$this->createText($text, array('value'=>$v)));
            }
            $flt['values'] = $values;
        }
        if ($type == "range_date"){
            //Set ranges
            if ( !$query ){
                $flt['min'] = $value['min'] >= 0 ? $value['min'] : 0;
                $flt['max'] = $value['max'];
            }
            else{
                $res = $this->mngrDB->mysqlGet($query);
                $res = $res[0];
                $max = $this->mysql2timestamp($res['vmax']);// - 60*60*25;
                $min = $this->mysql2timestamp($res['vmin']);// + 60*60*25;
                $flt['min'] = $min >= 0 ? $min : 0;
                $flt['max'] = $max >= 0 ? $max : 1;
            }
            $flt['selected_min'] = !empty($value['selected_min']) ? $value['selected_min'] : $min;
            $flt['selected_max'] = !empty($value['selected_max']) ? $value['selected_max'] : $max;
        }

        $this->available_filters[$name] = $flt;
		//var_dump($this->available_filters);
    }
}

class MegaFilter extends MegaFilterBase{

    public $mainquery = "";
    
    function GetData($additional='',$gr='', $search_results=array()){

        if (!empty($search_results['select'])) $this->fgroup = $search_results['select'] . ' ' . $this->fgroup;
        
        $q = $this->ConstructQuery();
        $res = $this->mngrDB->mysqlGet($q['full']);
        
        $count = !empty($this->countquery) ? $q['count'] : "SELECT COUNT(*) AS count FROM (".$q['lite'].") as tab";
        $count = $this->mngrDB->mysqlGet($count);
        if ($count) 
            foreach($count[0] as $cvalue){ $count = intval($cvalue); break; }
        else 
            $count = 0;
        
        if ($additional){
            foreach($res as $k=>$v){
                $res[$k]['adminactions'] = $this->createText($additional, $v);
                if (!empty($search_results['main_fld']) && !empty($search_results['found'][$v[$search_results['main_fld']]])) 
                    $res[$k]['adminsearch'] = $search_results['found'][$v[$search_results['main_fld']]];
            }
        }

        

        $this->result  = $res;
        $this->rcount  = $count;
    }

    function  IsInRequest($name) {
        return true;
    }

}

class HistMegaFilter extends MegaFilterBase{

    public $mainquery = "";

    function GetData($additional='',$gr=''){

        $q = $this->ConstructQuery();
        #echo $q['full']."\n\n";
        $res = $this->mngrDB->mysqlGet($q['nolimit']);

        $count = explode('FROM', $this->mainquery);
        $count = "SELECT COUNT(*) AS count FROM (".$q['lite'].") as tab";
		//var_dump($count);
        $count = $this->mngrDB->mysqlGet($count);
		//var_dump($count);
        if ($additional){
            foreach($res as $k=>$v){
                $res[$k]['adminactions'] = $this->createText($additional, $v);
            }
        }
        global $admin;
        foreach($res as $k=>$v){
            @$cols = explode(',', $res[$k]['cols']);
            $res[$k]['cols'] = array();
            foreach ($cols as $c){
                $res[$k]['cols'][] = array_key_exists($c, $admin->fields) && !empty($admin->fields[$c]['name']) ? $admin->fields[$c]['name'] : $c;

            }
            $res[$k]['cols'] = array_unique(array_filter($res[$k]['cols']));
            $res[$k]['cols'] = join(', ', $res[$k]['cols']);

            $res[$k]['whochange'] = str_replace(' (', ' <br>(', $admin->GetAdminById($res[$k]['admin_id']));
        }



        $this->result = $res;
        $this->rcount  = $count ? (int)$count[0]['count'] : 0;
    }

    function  IsInRequest($name) {
        return true;
    }

}
?>