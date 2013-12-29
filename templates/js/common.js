function applyAction() {
	var name, tel, email;
	name = $('#full_name').val();
	tel = $('#phone').val();
	email = $('#email').val();
	$.get('/ajax/applyAction',
			{
				name : name,
				tel  : tel,
				email: email
			},
			function(result) {
				if(+result == 1)
					alert('Заявка успешно отправлена');
				else
					alert('Ошибка обработки. Попробуйте заново.');
			}
	);
};