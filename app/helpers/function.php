<?php
/**返回给前台数据和状态,数据返回JSON格式
 * @param $code
 * @param $msg
 * @param string $datas
 * @return \Illuminate\Http\JsonResponse
 */
     function responseToJson($code, $msg, $datas = ''){
         $res["code"] = $code;
         $res["msg"] = $msg;
         $res["datas"] = $datas;
         return response()->json($res);
     }
/**返回给后台自身状态
 * @param $code
 * @param $msg
 * @param string $datas
 * @return mixed
 */
     function responseStatus($code, $msg, $datas = ''){
         $res["code"] = $code;
         $res["msg"] = $msg;
         $res["datas"] = $datas;
         return $res;
     }