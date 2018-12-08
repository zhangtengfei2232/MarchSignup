<?php
//循环判断信息是否为空
    function isempty($datas){
        foreach ($datas as $key => $data){
            if(is_numeric($data)){
                if($data == "") return true;
            }else{
                if(empty($data)) return true;
            }
        }
    }
//验证学生信息
    function judgeStudnetField($datas){
        if(isempty($datas)) return responseStatus(1,'你填写的信息不完整');
        if(strlen($datas['name']) > 15){
            return responseStatus(1,'你输入的姓名过长');
        }elseif (strlen($datas['profession']) > 30){
            return responseStatus(1,'你输入的专业名称过长');
        }elseif (strlen($datas['class']) > 20){
            return responseStatus(1,'你输入的班级名字过长');
        }elseif (strlen($datas['phone']) > 11 || !preg_match($datas['phone'],"/^1[3|5|7|8|4|9|6]\d{9}$/")){
            return responseStatus(1,'你输入的手机号有误');
        }elseif (strlen($datas['student_id']) != 11 || !preg_match($datas['student_id'],"/^2019\d{7}$/")){
            return responseStatus(1,'你输入的学号有误');
        }else{
            return responseStatus(0,'验证通过');
        }
    }