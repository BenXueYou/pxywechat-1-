<?php

$str = "123456789";
echo json_encode($str);

?> ajax = $.ajax({
        
        	type:"GET",
            url:"../../getCode.php",
            dataType:"json",
        	success:function(data){
            
            	alert("qingiquchengogng");
            	
                console.log("data"+data);
            
            },
            error:function(jqXHR){
        
                console.log('请求失败'+jqXHR);
        	}
        
        
        });
        
        