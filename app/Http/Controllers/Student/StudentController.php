<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Model\StudentDatabase;
use Illuminate\Http\Request;
class StudentController extends Controller
{
    /**学生报名,把信息放入数据库
     * @param Request $request
     * @return string
     */
    public function addStudent(Request $request){
        $datas = [
            'name'       => trim($request->name),
            'sex'        => trim($request->sex),
            'faculty'    => trim($request->faculty),
            'profession' => trim($request->profession),
            'class'      => trim($request->class),
            'student_id' => trim($request->student_id),
            'phone'      => trim($request->phone),
            'QQ'         => trim($request->QQ)
        ];
        $judge_information  = judgeStudnetField($datas);
        if($judge_information['code'] == 1){
            return responseToJson(1,$judge_information['msg']);
        }
        $datas['introduce'] = $request->introduce;
        return StudentDatabase::addStudentDatas($datas);
    }
    /**修改学生的信息
     * @param Request $request
     * @return string
     */
    public function reset(Request $request){
        $student_id = trim($request->student_id);
        $phone      = trim($request->phone);
        $is_exist_phone = StudentDatabase::byStudnetIdSelectIsExistPhone($student_id,$phone);
        if($is_exist_phone){
            return responseToJson(1,'电话号码已被占用');
        }
        $datas = [
            'name'       => trim($request->name),
            'sex'        => trim($request->sex),
            'faculty'    => trim($request->faculty),
            'profession' => trim($request->profession),
            'class'      => trim($request->class),
            'student_id' => $student_id,
            'phone'      => $phone,
            'QQ'         => trim($request->QQ)
        ];
        $judge_information = judgeStudnetField($datas);
        if($judge_information['code'] == 1){
            return responseToJson(1,$judge_information['msg']);
        }
        $datas['introduce'] = $request->introduce;
        return StudentDatabase::updateStudentDatas($datas);
    }
    /**根据学生ID查找学生信息
     * @param Request $request
     * @return string
     */
    public function search(Request $request){
        $student_id = trim($request->student_id);
        if(strlen($student_id) != 11 || !preg_match($student_id,"/^2019\d{7}$/")){
            return responseToJson(1,',学号有误，请重新填写学号');
        }
        return StudentDatabase::selectStudentDatas($student_id);
    }
    /**根据学生提交的学号，去查看学生是否已经报名=====>为了防止学生支付宝支付时候，
     * 支付成功却因为学号或手机号已经存在，而无法报名
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function selectStudentIsSignUp(Request $request){
         $is_exist_studnet = StudentDatabase::isExistStudent($request->student_id);
         if($is_exist_studnet){
             return responseToJson(1,'学号已经被占用');
         }
         $is_exist_phone = StudentDatabase::isExistPhone($request->phone);
         if($is_exist_phone){
             return responseToJson(1,'未经报名');
         }
         return responseToJson(1,'未经报名');
    }
    //获取学生的院系信息
    public function getFaculty(){
        dd(55);
         return responseToJson(0,'查询成功',config('studentinfor.faculty'));
    }
}