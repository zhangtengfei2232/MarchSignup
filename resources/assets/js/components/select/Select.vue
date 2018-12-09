<template>
    <div>
        {{ this.change_date() }}
        <el-form :inline="true">
            <el-form-item style="width:74%;" class="my_item search-item searchnum">
                <el-input style="" v-model="student_id" placeholder="输入学号查找" class="searinputs" ></el-input>
            </el-form-item>
            <el-form-item style="width: 23%; float: right" class="my_item search-item gosear">
                <el-button class="search-button" type="primary" icon="search" @click="onSearchClick"
                           :loading="searching" style="width:100%;">
                </el-button>
            </el-form-item>
        </el-form>
        <div style="width: 100%; overflow: hidden" v-if="show_meg" class="information">
            <el-row :gutter="20">
                <el-col class="title" :span="10">姓名</el-col>
                <el-col :span="14">{{ student.name }}</el-col>
            </el-row>
            <el-row :gutter="20">
                <el-col class="title" :span="10">性别</el-col>
                <el-col :span="14">{{ sex[student.sex] }}</el-col>
            </el-row>
            <el-row :gutter="20">
                <el-col class="title" :span="10">院系</el-col>
                <el-col :span="14">{{ faculty[student.faculty] }}</el-col>
            </el-row>
            <el-row :gutter="20">
                <el-col class="title" :span="10">专业</el-col>
                <el-col :span="14">{{ student.profession }}</el-col>
            </el-row>
            <el-row :gutter="20">
                <el-col class="title" :span="10">班级</el-col>
                <el-col :span="14">{{ student.class }}</el-col>
            </el-row>
            <el-row :gutter="20">
                <el-col class="title" :span="10">电话</el-col>
                <el-col :span="14">{{ student.phone }}</el-col>
            </el-row>
            <el-row :gutter="20">
                <el-col class="title" :span="10">QQ</el-col>
                <el-col :span="14">{{ student.QQ }}</el-col>
            </el-row>
            <el-row :gutter="20">
                <el-col class="title" :span="10">时间</el-col>
                <el-col :span="14">{{new Date(student.create_time).format('yyyy-MM-dd hh:mm')}}</el-col>
            </el-row>
            <el-row :gutter="20">
                <el-col class="title" :span="10">个人简历</el-col>
                <el-col :span="14" class="introduce">{{ student.introduce }}</el-col>
            </el-row>
            <el-row :gutter="20">
                <el-col class="title ispay" :span="10">是否付款</el-col>
                <el-col :span="14"  v-if = "student.is_pay">已付款</el-col>
                <el-col :span="14"  v-else>
                    未付款 <el-button type="primary" size="small" @click="chosepay">去付款</el-button>
                </el-col>
            </el-row>
            <el-button class="reset_submit" type="primary" @click="reset">修改</el-button>
        </div>
        <el-form  class="bigform" ref="form" :model="student" v-if="show_reset" style="margin-top: 23px">
            <el-form-item>
                <el-input placeholder="姓名" v-model="student.name"></el-input>
            </el-form-item>
            <el-form-item>
                <el-select v-model="student.sex" placeholder="请选择性别" style="width: 100%">
                    <el-option label="女" value="0"></el-option>
                    <el-option label="男" value="1"></el-option>
                </el-select>
            </el-form-item>
            <el-form-item>
                <el-select v-model="student.faculty" placeholder="请选择院系" style="width: 100%">
                    <el-option v-for="(item,index) in faculty_datas" :key="index" :value="index">{{item}}</el-option>
                </el-select>
                <div class="open opens"><span>新科学院暂未开放</span></div>
            </el-form-item>
            <el-form-item>
                <el-input placeholder="专业" v-model="student.profession"></el-input>
            </el-form-item>
            <el-form-item>
                <el-input placeholder="班级" v-model="student.class"></el-input>
            </el-form-item>
            <el-form-item>
                <el-input placeholder="学号" v-model="student.student_id"></el-input>
            </el-form-item>
            <el-form-item>
                <el-input placeholder="电话号码" v-model="student.phone"></el-input>
            </el-form-item>
            <el-form-item>
                <el-input placeholder="QQ号码" v-model="student.QQ"></el-input>
            </el-form-item>
            <el-form-item>
                <el-input placeholder="个人简历 ...... 不要超过150字哦！" v-model="student.introduce" type="textarea" :maxlength="150"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button class="my_submit" type="primary" @click="onSubmit">修改</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>

<style>
    .introduce{
        width: 100%;
        margin-top: 2%;
    }
    .el-textarea textarea{
        height: 100px;
    }
    @media (min-width: 200px) and (max-width: 499px) {
          .my_item{
              margin-right: 0 !important;
          }
    }
    .big{
          height: 1500px;
      }
    .reset_submit{
        margin-top: 20px;
        width: 100%;
    }
    .my_submit{
        width: 100%;
    }
    .search-item{
        margin-bottom: 0 !important;
    }
    .el-form-item__content{
        width: 100%;
    }
    .el-row{
        padding: 20px 0;
        border-bottom: 1px #74787E solid;
    }
    .weui-cell{
        width: 100%;
    }
      @media  only screen and (min-width: 500px){
        .my_submit{
            margin-left: 0px!important;
            background-color: #c5d4e8;
          }
        .searchnum{
            width: 18% !important;
            margin-left: 28%;
        }
        .gosear{
            margin-right: 26% !important;
            width: 14% !important;
        }
        .el-input__inner{
            height: 50px;
        }
        .searinputs{
            font-size: 17px!important;
        }
        .el-button--primary{
            height: 44px;
        }
        .information{
            color: #fff;
            width: 52% !important;
            margin-left: 33%;
            margin-top: 3%;

        }
        .reset_submit{
            width: 100px;
            margin-left: 25%;
        }
        .el-row{
            width: 67%;
        }
        .el-col{
            padding-left: 73px;
        }
        .ispay{
            margin-top: 3%;
        }
        .bigform{
            width: 40%;
            margin-left: 30%;
        }
        .opens{
            margin-top: -1%;
            color: red;
            height: 6px;
            text-align: center;
        }
    }
</style>
<script>
    export default {
        data() {
            return {
                sex       :['女','男'],
                faculty_datas: '',
                pay_ways : 0,
                is_pc     : false,
                show_meg  : false,
                show_reset: false,
                student_id: '',
                searching : false,
                direction : '开发',
                student   : {
                    name        : '',
                    sex         : '',
                    faculty     : '',
                    profession  : '',
                    class       : '',
                    student_id  : '',
                    phone       : '',
                    QQ          : '',
                    introduce   : '',
                    create_time : 0,
                    is_pay      : 0
                }
            }
        },
        methods: {
            onSearchClick() {
                this.searching = true;
                this.remove_spaces();
                if(this.test()){
                    this.$http.post('/search',{
                        student_id : this.student_id
                    }).then(
                        function (response) {
                            var data = response.data;
                            this.searching = false;
                            if(data.code == 0){
                                this.show_reset = false;
                                this.show_meg = true;
                                self.student = data.datas;
                            } else {
                                this.$message({
                                    showClose: true,
                                    message: data.msg,
                                    type: 'error'
                                });
                            }
                        }
                    )
                }
                this.searching = false;
            },
            onSubmit() {
                let self = this;
                self.remove_spaces();
                if(!self.test(self.student)){
                    return false;
                }
                this.$http.post('/updatestudent',{
                    name       : self.student.name,
                    sex        : self.student.sex,
                    faculty    : self.student.faculty,
                    profession : self.student.profession,
                    class      : self.student.class,
                    student_id : self.student.student_id,
                    phone      : self.student.phone,
                    QQ         : self.student.QQ,
                    introduce  : self.student.introduce
                }).then(
                    function (response) {
                        var data = response.data;
                        if(data.code == 0){
                            this.$message({
                                showClose: true,
                                message: data.msg,
                                type: 'success'
                            });
                            this.show_reset = false;
                            this.show_meg   = true;
                        } else {
                            this.$message({
                                showClose: true,
                                message: data.msg,
                                type: 'error'
                            });
                        }
                    }
                )
            },
            change_date(){
                Date.prototype.format = function (fmt) {
                    var o = {
                        "M+": this.getMonth() + 1,                      //月份
                        "d+": this.getDate(),                           //日
                        "h+": this.getHours(),                          //小时
                        "m+": this.getMinutes(),                        //分
                        "s+": this.getSeconds(),                        //秒
                        "q+": Math.floor((this.getMonth() + 3) / 3),    //季度
                        "S" : this.getMilliseconds()                    //毫秒
                    };
                    if (/(y+)/.test(fmt)) {
                        fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
                    }
                    for (var k in o) {
                        if (new RegExp("(" + k + ")").test(fmt)) {
                            fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
                        }
                    }
                    return fmt;
                }
            },
            reset(){
                this.student.sex        = this.sex[this.student.sex];
                this.student.faculty    = this.faculty[this.student.faculty];
                this.student.student_id = this.student_id;
                this.show_meg           = false;
                this.show_reset         = true;
            },
            getfacultys(){
                this.$http.get('/getfaculty', {
                }).then(function(response){
                    this.faculty_datas = response.data.datas;
                })
            }
        },
        mounted: function () {
            this.getfacultys();
        }
    }
</script>
