<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>带验证的表单向导</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="form_wizard.html#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="form_wizard.html#">选项1</a>
                            </li>
                            <li><a href="form_wizard.html#">选项2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <h2>
                        带验证的表单向导
                    </h2>
                    <p>
                        下面这个示例展示了如何在表单向导中使用 jQuery Validation 插件
                    </p>

                    <form id="form" action="form_wizard.html#" class="wizard-big">
                        <h1>账户</h1>
                        <fieldset>
                            <h2>账户信息</h2>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label>用户名 *</label>
                                        <input id="userName" name="userName" type="text" class="form-control required">
                                    </div>
                                    <div class="form-group">
                                        <label>密码 *</label>
                                        <input id="password" name="password" type="text" class="form-control required">
                                    </div>
                                    <div class="form-group">
                                        <label>确认密码 *</label>
                                        <input id="confirm" name="confirm" type="text" class="form-control required">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="text-center">
                                        <div style="margin-top: 20px">
                                            <i class="fa fa-sign-in" style="font-size: 180px;color: #e5e5e5 "></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </fieldset>
                        <h1>个人资料</h1>
                        <fieldset>
                            <h2>个人资料信息</h2>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>姓名 *</label>
                                        <input id="name" name="name" type="text" class="form-control required">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Email *</label>
                                        <input id="email" name="email" type="text" class="form-control required email">
                                    </div>
                                    <div class="form-group">
                                        <label>地址 *</label>
                                        <input id="address" name="address" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <h1>警告</h1>
                        <fieldset>
                            <div class="text-center" style="margin-top: 120px">
                                <h2>你是火星人 :-)</h2>
                            </div>
                        </fieldset>

                        <h1>完成</h1>
                        <fieldset>
                            <h2>条款</h2>
                            <input id="acceptTerms" name="acceptTerms" type="checkbox" class="required">
                            <label for="acceptTerms">我同意注册条款</label>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>添加产品</h5>
                </div>
                <div class="ibox-content">
                    <form method="get" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">产品名称</label>

                            <div class="col-sm-4">
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">产品类目</label>

                            <div class="col-sm-4">
                                <select class="form-control m-b" name="account">
                                    <option>选项 1</option>
                                    <option>选项 2</option>
                                    <option>选项 3</option>
                                    <option>选项 4</option>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">带说明信息</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"> <span class="help-block m-b-none">帮助文本，可能会超过一行，以块级元素显示</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">密码</label>

                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">提示</label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="提示信息" class="form-control">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">禁用</label>

                            <div class="col-sm-10">
                                <input type="text" disabled="" placeholder="已被禁用" class="form-control">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">静态控制</label>

                            <div class="col-sm-10">
                                <p class="form-control-static">i@zi-han.net</p>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">复选框&amp;单选框
                                <br/>
                                <small class="text-navy">普通Bootstrap元素</small>
                            </label>

                            <div class="col-sm-10">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="">选项1</label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" checked="" value="option1" id="optionsRadios1" name="optionsRadios">选项1</label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" value="option2" id="optionsRadios2" name="optionsRadios">选项2</label>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">内联复选框</label>

                            <div class="col-sm-10">
                                <label class="checkbox-inline">
                                    <input type="checkbox" value="option1" id="inlineCheckbox1">a</label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" value="option2" id="inlineCheckbox2">b</label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" value="option3" id="inlineCheckbox3">c</label>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">复选框&amp;单选框
                                <br/><small class="text-navy">自定义样式</small>
                            </label>

                            <div class="col-sm-10">
                                <div class="checkbox i-checks">
                                    <label>
                                        <input type="checkbox" value=""> <i></i> 选项1</label>
                                </div>
                                <div class="checkbox i-checks">
                                    <label>
                                        <input type="checkbox" value="" checked=""> <i></i> 选项2（选中）</label>
                                </div>
                                <div class="checkbox i-checks">
                                    <label>
                                        <input type="checkbox" value="" disabled="" checked=""> <i></i> 选项3（选中并禁用）</label>
                                </div>
                                <div class="checkbox i-checks">
                                    <label>
                                        <input type="checkbox" value="" disabled=""> <i></i> 选项4（禁用）</label>
                                </div>
                                <div class="radio i-checks">
                                    <label>
                                        <input type="radio" value="option1" name="a"> <i></i> 选项1</label>
                                </div>
                                <div class="radio i-checks">
                                    <label>
                                        <input type="radio" checked="" value="option2" name="a"> <i></i> 选项2（选中）</label>
                                </div>
                                <div class="radio i-checks">
                                    <label>
                                        <input type="radio" disabled="" checked="" value="option2"> <i></i> 选项3（选中并禁用）</label>
                                </div>
                                <div class="radio i-checks">
                                    <label>
                                        <input type="radio" disabled="" name="a"> <i></i> 选项4（禁用）</label>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">内联复选框</label>

                            <div class="col-sm-10">
                                <label class="checkbox-inline i-checks">
                                    <input type="checkbox" value="option1">a</label>
                                <label class="checkbox-inline i-checks">
                                    <input type="checkbox" value="option2">b</label>
                                <label class="checkbox-inline i-checks">
                                    <input type="checkbox" value="option3">c</label>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Select</label>

                            <div class="col-sm-10">

                                <div class="col-sm-4 m-l-n">
                                    <select class="form-control" multiple="">
                                        <option>选项 1</option>
                                        <option>选项 2</option>
                                        <option>选项 3</option>
                                        <option>选项 4</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group has-success">
                            <label class="col-sm-2 control-label">验证通过</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group has-warning">
                            <label class="col-sm-2 control-label">未填写</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group has-error">
                            <label class="col-sm-2 control-label">验证未通过</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">自定义尺寸</label>

                            <div class="col-sm-10">
                                <input type="text" placeholder=".input-lg" class="form-control input-lg m-b">
                                <input type="text" placeholder="Default input" class="form-control m-b">
                                <input type="text" placeholder=".input-sm" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">列尺寸</label>

                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-md-2">
                                        <input type="text" placeholder=".col-md-2" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" placeholder=".col-md-3" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" placeholder=".col-md-4" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">文本框组</label>

                            <div class="col-sm-10">
                                <div class="input-group m-b"><span class="input-group-addon">@</span>
                                    <input type="text" placeholder="用户名" class="form-control">
                                </div>
                                <div class="input-group m-b">
                                    <input type="text" class="form-control"> <span class="input-group-addon">.00</span>
                                </div>
                                <div class="input-group m-b"><span class="input-group-addon">&yen;</span>
                                    <input type="text" class="form-control"> <span class="input-group-addon">.00</span>
                                </div>
                                <div class="input-group m-b"><span class="input-group-addon"> <input type="checkbox"> </span>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="input-group"><span class="input-group-addon"> <input type="radio"> </span>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">按钮插件</label>

                            <div class="col-sm-10">
                                <div class="input-group m-b"><span class="input-group-btn">
                                            <button type="button" class="btn btn-primary">搜</button> </span>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="input-group">
                                    <input type="text" class="form-control"> <span class="input-group-btn"> <button type="button" class="btn btn-primary">搜索
                                        </button> </span>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">带下拉框</label>

                            <div class="col-sm-10">
                                <div class="input-group m-b">
                                    <div class="input-group-btn">
                                        <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">操作 <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="form_basic.html#">选项1</a>
                                            </li>
                                            <li><a href="form_basic.html#">选项2</a>
                                            </li>
                                            <li><a href="form_basic.html#">选项3</a>
                                            </li>
                                            <li class="divider"></li>
                                            <li><a href="form_basic.html#">选项4</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="input-group">
                                    <input type="text" class="form-control">

                                    <div class="input-group-btn">
                                        <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">操作 <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu pull-right">
                                            <li><a href="form_basic.html#">选项1</a>
                                            </li>
                                            <li><a href="form_basic.html#">选项2</a>
                                            </li>
                                            <li><a href="form_basic.html#">选项3</a>
                                            </li>
                                            <li class="divider"></li>
                                            <li><a href="form_basic.html#">选项4</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">分段</label>

                            <div class="col-sm-10">
                                <div class="input-group m-b">
                                    <div class="input-group-btn">
                                        <button tabindex="-1" class="btn btn-white" type="button">操作</button>
                                        <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button"><span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="form_basic.html#">选项1</a>
                                            </li>
                                            <li><a href="form_basic.html#">选项2</a>
                                            </li>
                                            <li><a href="form_basic.html#">选项3</a>
                                            </li>
                                            <li class="divider"></li>
                                            <li><a href="form_basic.html#">选项4</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="input-group">
                                    <input type="text" class="form-control">

                                    <div class="input-group-btn">
                                        <button tabindex="-1" class="btn btn-white" type="button">操作</button>
                                        <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button"><span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu pull-right">
                                            分段
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="submit">保存内容</button>
                                <button class="btn btn-white" type="submit">取消</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import JqueryStep from 'jquery.step/dist/jquery.step.min.js'
export default{
    ready(){
        console.log(JqueryStep);
    }
}
</script>
