
    <div class="col-md-12 app-inner-layout__content card">
        <div class="pb-1 pl-1 pr-1 pt-3">
            <div class="tab-content">
                <div class="tab-pane active show" id="tab-faq-1">

                    <div id="accordion" class="accordion-wrapper mb-3">
                        <div class="card">
                            <div id="headingOne" class="card-header">
                                <button type="button" data-toggle="collapse" data-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne" class="text-left m-0 p-0 btn btn-link btn-block">
                                    <h5 class="m-0 p-0">WeTrue <n i18n="UpdateLog">更新日志</n></h5>
                                </button>
                            </div>
                            <div data-parent="#accordion" id="collapseOne1" aria-labelledby="headingOne" class="collapse show">
                                <div class="card-body">
                                <textarea class="form-control-plaintext text_ZeroFrame autosize-input" style="max-height:600px;" readonly>
WeTrue.io 更新历程
2021-03-29
新增WTT显示
修复AE金额跨域问题

2021-03-23 --> 1.2.0
新增全站数据统计

2021-03-21 --> 1.1.2
时间个位补零

2021-03-20
新增屏蔽用户活跃度扣除功能
新增配置文件活跃度设置

2021-03-14
xxs安全防御[感谢 near Xy²]

2021-03-07 --> 1.1.0
新增热点推荐时间配置
新增密码自动填充

2021-03-06 --> 1.1.0
新增WTT空投
更名 WeTrueConfig 为 Config
调整全站统一调用
调整代码结构
修复多处代码错误

2021-03-03
修复部分Bug
优化代码

2021-03-01
修复点赞活跃度不增加BUG[感谢 夜空]
修复评论活跃度不增加BUG[感谢 卖酒的半仙]
更换全站LOGO[感谢 粗粮]

2021-02-27
替换懒加载默认图片
替换favicon默认图标
修复管理页举报
修复管理页屏蔽
修改活动屏蔽引起的错误

2021-02-18 --> 1.0.6
新增getAccounts解决跨域问题
合并积分调用
调整模块用户页调用
修复密码不显示为*

2021-02-17
修复名称点击跳转错误问题
修复我的关注页面问题

2021-01-31
对已领取IP增加标记
添加进入生成助记词页面自动生成
修改header防止谷歌翻译自动启动
删除早鸟福利
更新使用问答

2021-01-28 --> 1.0.5
增加cookie及IP双重验证
调整页面底部调用降低维护量
修复一处因更新引起的错误
修复因更新引起的管理页面错误

2021-01-27
修改文章头部排版
修改文章底部排版
修改最新评论排版
修改修改屏蔽提示语
移除底栏按钮
修改SeeMore文件名

2021-01-26 --> 1.0.3
去除无用icon库
更换FontAwesome icon为5.15.2

2021-01-25 --> 1.0.2
新增新用户活动领取AE功能

2021-01-24
更换FontAwesome字体库为4.7.0[废弃]
调整个人中心页布局

2021-01-23
对部分页面排版微调

2021-01-21 --> 1.0.0
-新增footer_SDK页面
-修改WeTter SDK获取AE余额方式
-调整仅在需要调用AESDK页面提高加载速度

2021-01-04 --> 0.8.0
-新增主贴搜索
-新增评论搜索
-新增用户搜索

2020-12-30
-修复管理URL
-防止登录时浏览器记住助记词及密码
-防止发帖及评论时浏览器记住内容及密码

2020-12-08
新增banner AE价格展示
修改WeTrueConfig价格API

2020-11-16 --> 0.7.0
-修复回复tx错乱提交到主贴
-修复Models\Portraits错误标签[1处]
-修复SeeMore路径错误[4处]
-更新header调用SDK路径
-更新WetSDK上链content_type标签[3处]
-更新Models\Contents标签[1处]
-更新Models\Comments标签[1处]
-更新Models\Portraits标签[1处]
-重写人工提交验证

2020-11-15
-更新SDK为官方SDK
-更新节点为官方
-修复主贴及评论逻辑错误
-已知问题，回复tx错乱提交到主贴[等待修复]

2020-11-13
-更新AEChina因cache权限问题
-更新aepps store因cache权限问题
-更新主节点位置

2020-11-08
-完成 WeTrue.io 主站迁移,更换新服务器
-完成 AEChina.io 主站迁移,更换新服务器
-完成 aepp.AEChina.io 主站迁移,更换新服务器
-完成 node.AEChina.io 迁移,更换新服务器

2020-11-07
-完成 AEChina.io 数据库迁移
-完成 aepp.AEChina.io 数据库迁移

2020-11-06
-Wetrue更换新服务器
-完成服务器环境部署
-完成服务器安全部署

2020-11-05
-更换高性能服务器
-全新升级的数据库结构
-完成无缝迁移数据库

2020-10-22
-更换node.AEChina.io节点硬件
-升级主节点至v5.5.4

2020-09-19 --> 0.6.5
-升级AEPP-SDK 至 7.7.0
-优化多处数据加载

2020-07-08 --> 0.6.2
-修复一处缓存错误
-修改FAQ收费描述
-发帖费用降低为0【仅需矿工费】
-评论费用降低为0【仅需矿工费】
-个性化服务费用降低为0【仅需矿工费】
-升级版本号至0.6.2

2020-06-26
-升级AEPP-SDK 至 7.5.0
-更新服务器跨域Origin报错

2020-06-19
-优化头像修改速度
-优化昵称修改速度

2020-06-18
-优化修改头像活跃度BUG
-优化修改昵称活跃度BUG

2020-06-10
-即日起至7月31日不收取个性化服务费
-即日起至7月31日【发帖】费用降低10%
-即日起至7月31日【评论】费用降低10%
-修改更新 Why And Tow To Charge

2020-05-30
-新增【我的关注】

2020-05-29
-新增【关注】与【取消关注】
-新增【关注列表】与【被关注列表】

2020-05-28 --> 0.6.1
-修复【最新图片】变形问题
-修复一处统计错误
-图片缓存从1天修改为7天
-帮助1新增[如何获取AE]
注：经线上测试，当前整体已趋于完善，近期未存在重大问题将不再修改原有功能，将着手开发新功能
【关注】 - 预计包含测试3天完成
【话题】 - 于完成关注后进入开发阶段

2020-05-26
-修改一处AE账户，提高superhero兼容性

2020-05-19
-修改【热点推荐】周期15天-->10天
-修复部分点赞缓存不更新
-修复部分评论缓存不更新

2020-05-18
-新增多处自动缓存，提升访问效率
-新增图片缓存报头，时间1天
-优化特定情景下数据获取效率

2020-05-17 --> 0.6.0
-修复IOS及部分设备上传头像横向问题
-修复IOS及部分设备发帖图片横向问题

2020-05-16 --> 0.5.9
-新增用户中心【评论】
-新增评论【TO：hash】

2020-05-14 --> 0.5.8
-新增【等级7】，活跃度10000
-新增等级颜色区分
-完整代码审查，及修复小部分遗留问题
（代码审查为不可视更新，已对全部可能存在的安全隐患梳理及更改）

2020-05-13
-新增用户页【活跃度】

2020-05-09
-修复最新评论下对评论评论显示无效hash
-修复0.5.3遗留的一个评论bug
-修复评论成功返回不加载评论数据
-修复头像及主帖透明图片背景变黑

2020-05-08 --> 0.5.7
-调整多个页面ajax加载
-修复手机端图片上传Chrome不显示问题
-调整【查看】位置-更符合使用习惯
-调整列表提高复用
-调整WET-SDK上拉逻辑

2020-05-06 --> 0.5.5
-新增上链超时取消
-新增智能长图判断逻辑
-调整发布图片清晰度
-重写发布图片逻辑，解决小概率图片丢失问题
-重写WET-SDK部分逻辑，提高效率

2020-05-05 --> 0.5.3
-完善用户页面、昵称修改页面、头像修改页面-英文翻译

2020-05-04 --> 0.5.3
-新增功能【热点推荐】
-二级评论与点赞计入主帖展示
-修复评论一错误链接

2020-05-03  --> 0.5.3
-添加对target="_blank"潜在安全问题预防
-添加i18n国际化语言
-添加中、英双语

2020-05-02 --> 0.5.2
-粗糙的先增加【最新图片】，将来增加跳转原贴
-修复主帖及评论Safari浏览器时间错误问题

2020-05-01 --> 0.5.1
-更换缩放图插件[如有图片非正常显示，需清空浏览器缓存]
-增加提交tx后端缓存
-增加底部返回首页按钮[临时]

2020-04-30 --> 0.5.0
-增加上拉刷新延时，解决Safari等浏览器重复内容问题
-未显示完整部分添加...
-添加【手动加载更多】，解决兼容性问题[暂时]
-调整首页、用户页排版
-修改首页、用户页预览文字字节
-修复用户页文章屏蔽问题

2020-04-28 --> 0.4.9
-添加更方便的hash提交
-添加hash预处理新流程，对不符合条件直接删除缓存
-修改hash预处理，调整处理流程
-调整部分页面js代码
-修复提交失败，后续提交帖子排序问题
-修复火狐等浏览器列表加载问题

2020-04-26 --> 0.4.8
-添加 导航栏-使用问答-常见问题
-添加 导航栏-更新日志
-升级AEPP-SDK 至 7.2.1
-修改导航栏为中文
-修改小部分WET-SDK逻辑
-移除WET-SDK-hex2str
-修复时区时间显示问题
-修复登录头像、昵称偶尔不加载问题
-移除主帖、评论页时间JS

2020-04-26 --> 0.4.5
WeTrue上线小范围公测 - 2020-04-26 01:54:59 [GTM+8]
                                </textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $this->load->view('footer_inside');?>
<?php $this->load->view('footer'); ?>