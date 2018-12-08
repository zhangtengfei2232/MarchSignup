<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class WeChatPayDatabase  extends Model
{
    /**
     * @param $student_id
     * @return mixed
     */
    //去查某个学生是否付款
    public static function weCounterStudentOrder($student_id)
    {
        return DB::table('wechatpay')->where('student_id',$student_id)->where('is_pay',1)->count();
    }
    /**  微信支付，对数据库的操作
     * @param $student_id
     * @param $phone
     * @param $out_trade_no
     * @return mixed
     */
   //把订单信息存入数据库
    public static function addStudentOrder($student_id,$phone,$out_trade_no,$pay_ways)
    {
        $rest = self::selectStudentIsPay($student_id);
        if($rest > 0){
            return responseStatus(1,'你已经付款');
        }
        $get_id = DB::table('wechatpay')
                  ->insertGetId([
                      'student_id'   => $student_id,
                      'phone'        => $phone,
                      'out_trade_no' => $out_trade_no,
                      'is_pay'       => 0,
                      'pay_ways'     => $pay_ways,
                      'created_time' => time()
                  ]);
        return ($get_id) ? responseStatus(0,'添加订单成功',$get_id)
                         : responseStatus(1,'添加订单失败');
    }
    //根据学生ID，去查学生是否已经交钱，如果已经交钱，不再插入支付宝订单
    public static function selectStudentIsPay($student_id)
    {
          return DB::table('wechatpay')->where(['student_id'=>$student_id,'is_pay'=>1])->count();
    }
    /**
     * @param $out_trade_no
     * @return mixed
     */
   //查询微信支付的订单号
    public static function sestuordernum($out_trade_no)
    {
        $order = DB::table('wechatpay')->where('out_trade_no',$out_trade_no)->first();
        return $order;
    }
    /**
     * @param $student_id
     * @return mixed
     */
    //根据学生ID查学生是否已经订单
    public static function acstuseorder($student_id)
    {
        $count = DB::table('wechatpay')->where('student_id',$student_id)->where('is_pay',1)->count();
        return $count;
    }
    /**
     * @param $out_trade_no
     */
   //根据订单号，修改学生的支付状态
    public static function updateorstatus($out_trade_no)
    {
        DB::table('wechatpay')->where('out_trade_no',$out_trade_no)->update([
            'is_pay'=>1,
            'updated_time' => time()
        ]);
    }
    /**
     * @param $oederid
     * @return mixed
     */
    //根据 “订单ID” ，去更新=>学生已交费
    public static function updateOrders($orderid)
    {
        $result = DB::table('wechatpay')->where('id',$orderid)
                  ->update([
                      'is_pay' => 1,
                      'updated_time' => time()
                  ]);
        return ($result == 1) ? responseToJson(0,'修改订单成功')
                              : responseToJson(1,'修改订单失败');
    }
    /** 支付宝独有的数据库操作
     * @param $arr
     * @return mixed
     */
    //根据“ out_trade_no ”，去查是否有第一个未付款的
    public static function acordoutranse($out_trade_no)
    {
        $count = DB::table('wechatpay')->where(['out_trade_no'=>$out_trade_no,'is_pay'=>0])->first();
        return $count;
    }
}