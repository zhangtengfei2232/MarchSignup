
exports.install = function (Vue, options) {
    Vue.prototype.remove_spaces = function (datas){
        datas.name        = datas.name.trim();
        datas.profession  = datas.profession.trim();
        datas.class       = datas.class.trim();
        datas.phone       = datas.phone.trim();
        datas.QQ          = datas.QQ.trim();
        return datas;
    };
    Vue.prototype.validateFields = function (datas){
        var reg_name    = /^[\u4E00-\u9FA5]{2,5}$/;
        var reg_id      = /^2019\d{7}$/;
        var reg_mobile  = /^1[3|5|7|8|4|9|6]\d{9}$/;
        var reg_phone   = /^0\d{2,3}-?\d{7,8}$/;
        if(!(reg_name.test(datas.name))){
            this.$message({
                showClose: true,
                message: '姓名错误，请重新填写',
                type: 'warning'
            });
        }else if(datas.class.length < 5 || datas.class.length > 10){
            this.$message({
                showClose: true,
                message: '班级错误，请重新填写',
                type: 'warning'
            });
        }else if(!reg_id.test(datas.student_id)){
            this.$message({
                showClose: true,
                message: '学号错误，请重新填写',
                type: 'warning'
            });
        }else if(!reg_mobile.test(datas.phone) && !reg_phone.test(datas.phone)){
            this.$message({
                showClose: true,
                message: '电话号码错误，请重新填写',
                type: 'warning'
            });
        }else{
            return true;
        }
        return false;
    };
};