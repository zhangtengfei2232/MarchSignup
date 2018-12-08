<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class StudentDatabase extends Model
{
    /**
     * @return mixed
     */
    //查询付款的学生的信息
    public static function seallstudent()
    {
        return DB::table('newstudent')->where('is_pay')->get();
    }
    /**
     * @param $student_id
     * @return bool
     */
    //根据学生ID匹配查询
    public static function isExistStudent($student_id)
    {
        $count = DB::table('newstudent')->where('student_id',$student_id)->count();
        return ($count > 0) ? true : false;
    }
    /**
     * @param $phone
     * @return bool
     */
    //根据学生Phone匹配查询
    public static function isExistPhone($phone)
    {
        $count = DB::table('newstudent')->where('phone',$phone)->count();
        return ($count > 0) ? true : false;
    }
    /**添加新学生信息
     * @param $datas
     * @return \Illuminate\Http\JsonResponse
     */
    public static function addStudentDatas($datas)
    {
        $student_id   = $datas['student_id'];
        $is_exists_student = StudentDatabase::isExistStudent($student_id);
        if($is_exists_student){
            return responseToJson(1,'已报名，请不要重复报名');
        }
        $phone = $datas['phone'];
        $acordstuphoe = StudentDatabase::isExistPhone($phone);
        if($acordstuphoe){
            return responseToJson(1,'电话号码被占用');
        }
        $creatime = ceil(microtime(true) * 1000);
        $add_student_get_id = DB::table('newstudent')
            ->insertGetid([
                'name'           => $datas['name'],
                'sex'            => $datas['sex'],
                'faculty'        => $datas['faculty'],
                'profession'     => $datas['profession'],
                'class'          => $datas['class'],
                'student_id'     => $datas['student_id'],
                'phone'          => $datas['phone'],
                'QQ'             => $datas['QQ'],
                'create_time'    => $creatime,
                'introduce'      => $datas['introduce']
        ]);
        return ($add_student_get_id) ? responseToJson(0,'报名成功') : responseToJson( 1, '报名失败，请重新报名');
    }
    /**
     * @param $student_id
     * @return string
     */
    //通过学生ID查询第一个学生的信息
    public static function selectStudentDatas($student_id)
    {
        $student = DB::table("newstudent")->where('student_id',$student_id)->first();
        return responseToJson(0,'查询成功',$student);
    }
    /**
     * @param $student_id
     * @param $phone
     * @return bool
     */
    //根据手机号和学生ID，,反查询，判断手机号是否被占用
    public static function byStudnetIdSelectIsExistPhone($student_id,$phone)
    {
       $count = DB::table("newstudent")->where('student_id','!=',$student_id)->where('phone',$phone)->count();
       return ($count > 0) ? true : false;
    }
    /**修改学生的信息
     * @param $datas
     * @return \Illuminate\Http\JsonResponse
     */
    public static function updateStudentDatas($datas)
    {
        $student_id = $datas['student_id'];
        $updatetime = ceil(microtime(true) * 1000);
        $response   = DB::table("newstudent")->where('student_id',$student_id)
                      ->update([
                           'name'        => $datas['name'],
                           'sex'         => $datas['sex'],
                           'faculty'     => $datas['faculty'],
                           'profession'  => $datas['profession'],
                           'class'       => $datas['class'],
                           'student_id'  => $student_id,
                           'phone'       => $datas['phone'],
                           'QQ'          => $datas['QQ'],
                           'introduce'   => $datas['introduce'],
                           'update_time' => $updatetime
                      ]);
        return ($response == 1) ? responseToJson(0,'修改信息成功') : responseToJson(1,'修改信息失败');
    }
}