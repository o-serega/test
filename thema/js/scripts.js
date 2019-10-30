$(document).ready(function(){
	
  kassa('month','');
  
});

var arrMonthName=[
   'Январь',
   'Февраль',
   'Март',
   'Апрель',
   'Май',
   'Июнь',
   'Июль',
   'Август',
   'Сентябрь',
   'Октябрь',
   'Ноябрь',
   'Декабрь',
];



function kassa(a,b){

	if(b){

		b = '?month_num='+b;

	}

	$.get(
	  "/ajax.php"+b,
	  {
		inquiry: a
	  },
	  function onAjaxSuccess(data){
		  
		  var dataJSON = jQuery.parseJSON(data),
				tri = 0,
				body_con = '';
		
		
		  for(var i = 0; i < dataJSON.length; i++){
			  
			  if(tri == 0){
				  
				  body_con += '<tr><th></th>';
				  
				  for(var ind = 0; ind < dataJSON.length; ind++){
					  
					  if(ind < 3){
						  
						body_con += '<th>Касса '+dataJSON[ind].number_kassa+'</th>';
					  
					  }
					  
				  }
				  
				  
				  body_con += '</tr>';
				  
			  }
			  
			  if(tri != dataJSON[i].month){
				  
				  body_con += '<tr>';

				  if(a == 'month'){

                      body_con += '<td><a href="#day" onclick="kassa(\'day\',' + dataJSON[i].month + ')">' + arrMonthName[dataJSON[i].month - 1] + '</a></td>';

                  }else if(a = 'day'){

                      body_con += '<td><a href="#cheks" onclick="kassaCkeck(\'cheks\',\''+dataJSON[i].month+'\')">'+dataJSON[i].month+'</a></td>';

				  }

				  
			  }
			  
			  body_con += '<td>'+parseInt(dataJSON[i].sum).toLocaleString()+'₽</td>';
			  tri = dataJSON[i].month;
			  
			  if(tri != dataJSON[i].month){
				  
				  body_con += '</tr>';
				  
				  
			  }
			  
		  }


		  $('#'+a+' table').html(body_con);

		  
	  }


	);

	
}


function kassaCkeck(a,b){

    if(b){

        b = '?month_num='+b;

    }


    $.get(
        "/ajax.php"+b,
        {
            inquiry: a
        },
        function onAjaxSuccess(data){

            var dataJSON = jQuery.parseJSON(data),
                body_con = '<tr><th>Номер кассы</th><th>Дата</th><th>Сумма</th></tr>';



            for(var i = 0; i < dataJSON.length; i++){


                body_con += '<tr><td>Каксса '+dataJSON[i].number_kassa+'</td><td>'+dataJSON[i].month+'</td><td>'+parseInt(dataJSON[i].sum).toLocaleString()+'₽</td></tr>';


            }


            $('#'+a+' table').html(body_con);


        }


    );


}