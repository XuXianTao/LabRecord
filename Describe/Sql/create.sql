drop database if exists `LabRecord`;
create database `LabRecord` character set utf8;
use `LabRecord`;

# day、name、type、group为MySQL保留关键字，字段中不应出现以避免冲突
# day → weekday
# name → nam
# type → typ
# group → grp

# 日期表 当前周数，星期几
create table the_date(
    id             int not null primary key,
    week           int not null default 1,
    weekday        int not null default 1,
    start_date     int,
    update_statu   boolean default false,             # 学生登录
    update_statu2  boolean default false              # 故障提交
) engine=InnoDB;
insert into the_date(id,week,start_date) values (1,1,1);

# 映像表 IP与座位号一一对应
create table ip (
    ip             varchar(20) not null primary key,  # ip地址
    cla            varchar(10) not null,              # 课室号
    num            varchar(10) not null               # 台号
) engine=InnoDB;

# 老师表
create table tea (
    id             int not null primary key,          # 职工号
    typ            int not null,                      # 类型，二进制位判断
    nam            varchar(10) not null               # 名字
) engine=InnoDB;

# 课程表
create table course (
    id             int not null primary key auto_increment,
                                                      # 课程id
    nam            varchar(30) not null,              # 课程名称
    cla            varchar(10) not null,              # 课室号
    tea_id         int not null,                      # 老师id
    sch_time_start time not null,                     # 上课时间
    sch_time_end   time not null,                     # 下课时间
    sch_year       varchar(20),                       # 学年
    sch_term       int,                               # 学期
    sch_day        varchar(10),                       # 工作日
    sch_week_start int,                               # 第几周开始上课
    sch_week_end   int,                               # 第几周结束上课
    grp_mem_num    int                                # 小组最多人数
) auto_increment=1 engine=InnoDB;

# 学生表
create table stu (
    id             int not null,                      # 学号
    nam            varchar(10) not null,              # 名字
    course_id      int not null,                      # 课程id
    primary key(id,course_id)
) engine=InnoDB;

# 助理表
create table ta (
    id            int not null primary key,           # 学号
    nam           varchar(10) not null,               # 姓名
    sch_year      varchar(20),                        # 学年
    sch_term      int,                                # 学期
    sch_time      varchar(30),                        # 具体时间-仅用作描述
    duty_time     int default 0
) engine=InnoDB;

# 组队表
create table grp (
    id             int not null primary key auto_increment,
                                                      # 小组id
    course_id      int not null,                      # 课程id
    stu1_id        int not null,                      # 组长id
    stu2_id        int default null,                  # 组员1 id
    stu3_id        int default null,                  # 组员2 id
    stu4_id        int default null                   # 组员3 id
) auto_increment=1 engine=InnoDB;

# 学生签到表
create table sign_stu (
    id             int not null,                      # 学号
    course_id      int not null,                      # 课程id
    ip             varchar(20),                       # 登录ip
    week           int not null,                      # 周数
    stat           varchar(10) default '未签到',       # 签到情况
    sign_in        datetime,                          # 登入时间
    sign_out       datetime,                          # 登出时间
    info           varchar(20) default ''             # 信息
) engine=InnoDB;

# 助理签到表
create table sign_ta (
    id            int not null,                       # 学号
    sign_in       datetime,                           # 签到/登入时间
    sign_out      datetime,                           # 登出时间
    cla           varchar(10),                        # 值班教室
    week          int not null,                       # 签到周数
    weekday       int not null,                       # 签到天数
    duty_time     int default 0                       # 当天执勤时长
) engine=InnoDB;

# 故障提交表
create table excp_submit (
    id            int not null primary key auto_increment,
                                                      # 提交故障的编号
    stu_id        int not null,                       # 学号
    cla           varchar(10) not null,               # 课室号
    num           varchar(10) not null,               # 台号
    submit_tim    datetime,                           # 提交时间
    excp_desc     varchar(200) not null               # 故障描述
) auto_increment=1 engine=InnoDB;

# 总体故障统计表，待定留用
create table excp_cnt (
);

# 示波器表
create table oscp (
    id            int not null primary key auto_increment,
                                                      # 登记用编号
    sch_id        varchar(10),                        # 校编号
    SN            varchar(30),                        # 序列号
    cla           varchar(10) not null,               # 当前课室号
    num           varchar(10) not null,               # 当前台号
    model         varchar(30) not null,               # 型号
    cnt           int not null default 0,             # 故障次数
    use_time      int not null default 0,             # 使用时长
    stat          int not null default 1              # 使用状态，1使用中，0未使用
) auto_increment=1 engine=InnoDB;

# 直流电源表
create table DCsource (
    id            int not null primary key auto_increment,
                                                      # 登记用编号
    sch_id        varchar(10),                        # 校编号
    SN            varchar(30),                        # 序列号
    cla           varchar(10) not null,               # 当前课室号
    num           varchar(10) not null,               # 当前台号
    model         varchar(30) not null,               # 型号
    cnt           int not null default 0,             # 故障次数
    use_time      int not null default 0,             # 使用时长
    stat          int not null default 1              # 使用状态，1使用中，0未使用
) auto_increment=1 engine=InnoDB;

# 万用电表表
create table DMM (
    id            int not null primary key auto_increment,
                                                      # 登记用编号
    sch_id        varchar(10),                        # 校编号
    SN            varchar(30),                        # 序列号
    cla           varchar(10) not null,               # 当前课室号
    num           varchar(10) not null,               # 当前台号
    model         varchar(30) not null,               # 型号
    cnt           int not null default 0,             # 故障次数
    use_time      int not null default 0,             # 使用时长
    stat          int not null default 1              # 使用状态，1使用中，0未使用
) auto_increment=1 engine=InnoDB;

# 显示器表
create table display (
    id            int not null primary key auto_increment,
                                                      # 登记用编号
    sch_id        varchar(10),                        # 校编号
    SN            varchar(30),                        # 序列号
    cla           varchar(10) not null,               # 当前课室号
    num           varchar(10) not null,               # 当前台号
    model         varchar(30) not null,               # 型号
    cnt           int not null default 0,             # 故障次数
    use_time      int not null default 0,             # 使用时长
    stat          int not null default 1              # 使用状态，1使用中，0未使用
) auto_increment=1 engine=InnoDB;

# 主机表
create table PCcase (
    id            int not null primary key auto_increment,
                                                      # 登记用编号
    sch_id        varchar(10),                        # 校编号
    SN            varchar(30),                        # 序列号
    cla           varchar(10) not null,               # 当前课室号
    num           varchar(10) not null,               # 当前台号
    model         varchar(30) not null,               # 型号
    cnt           int not null default 0,             # 故障次数
    use_time      int not null default 0,             # 使用时长
    stat          int not null default 1              # 使用状态，1使用中，0未使用
) auto_increment=1 engine=InnoDB;

# 功率因数表表
create table PM (
    id            int not null primary key auto_increment,
                                                      # 登记用编号
    sch_id        varchar(10),                        # 校编号
    SN            varchar(30),                        # 序列号
    cla           varchar(10) not null,               # 当前课室号
    num           varchar(10) not null,               # 当前台号
    model         varchar(30) not null,               # 型号
    cnt           int not null default 0,             # 故障次数
    use_time      int not null default 0,             # 使用时长
    stat          int not null default 1              # 使用状态，1使用中，0未使用
) auto_increment=1 engine=InnoDB;

# 函数发生器表
create table AWG (
    id            int not null primary key auto_increment,
                                                      # 登记用编号
    sch_id        varchar(10),                        # 校编号
    SN            varchar(30),                        # 序列号
    cla           varchar(10) not null,               # 当前课室号
    num           varchar(10) not null,               # 当前台号
    model         varchar(30) not null,               # 型号
    cnt           int not null default 0,             # 故障次数
    use_time      int not null default 0,             # 使用时长
    stat          int not null default 1              # 使用状态，1使用中，0未使用
) auto_increment=1 engine=InnoDB;

# 交流电路实验箱表
create table ACcirBox (
    id            int not null primary key auto_increment,
                                                      # 登记用编号
    sch_id        varchar(10),                        # 校编号
    SN            varchar(30),                        # 序列号
    cla           varchar(10) not null,               # 当前课室号
    num           varchar(10) not null,               # 当前台号
    model         varchar(30) not null,               # 型号
    cnt           int not null default 0,             # 故障次数
    use_time      int not null default 0,             # 使用时长
    stat          int not null default 1              # 使用状态，1使用中，0未使用
) auto_increment=1 engine=InnoDB;

# 电路基础实验箱表
create table CirFouBox (
    id            int not null primary key auto_increment,
                                                      # 登记用编号
    sch_id        varchar(10),                        # 校编号
    SN            varchar(30),                        # 序列号
    cla           varchar(10) not null,               # 当前课室号
    num           varchar(10) not null,               # 当前台号
    model         varchar(30) not null,               # 型号
    cnt           int not null default 0,             # 故障次数
    use_time      int not null default 0,             # 使用时长
    stat          int not null default 1              # 使用状态，1使用中，0未使用
) auto_increment=1 engine=InnoDB;

# 模拟电路实验箱表
create table AnaCirBox (
    id            int not null primary key auto_increment,
                                                      # 登记用编号
    sch_id        varchar(10),                        # 校编号
    SN            varchar(30),                        # 序列号
    cla           varchar(10) not null,               # 当前课室号
    num           varchar(10) not null,               # 当前台号
    model         varchar(30) not null,               # 型号
    cnt           int not null default 0,             # 故障次数
    use_time      int not null default 0,             # 使用时长
    stat          int not null default 1              # 使用状态，1使用中，0未使用
) auto_increment=1 engine=InnoDB;

# 配线表，需要进行默认导入
create table wire (
    kind          varchar(20) not null,               # 配线种类
    appar         varchar(20) not null,               # 配套仪器
    color         varchar(10) not null,               # 颜色
    num           int not null default 1              # 数量
) engine=InnoDB;

# 问卷or小测
create table que (
    qid           int not null primary key auto_increment,
                                                      # 问卷ID
    tea_id        int not null,                       # 老师id
    amount        int not null,                       # 问题个数
    title         varchar(80) not null                # 问卷标题
) auto_increment=1 engine=InnoDB;

# 问题
create table que_q (
    qid           int not null,                       # 问卷id
    num           int not null,                       # 第几个问题
    queid         varchar(80) not null primary key,   # id_num
    que           varchar(80) not null,               # 问题
    typ           varchar(80) not null                # 问卷or小测
) engine=InnoDB;

# 答案
create table que_a (
    queid         varchar(80) not null,               # 问题id
    num           int not null,                       # 第几个答案
    aid           varchar(80) not null primary key,   # queid_num
    ans           varchar(80) not null,               # 回答内容
    correct       boolean default false               # 是否正确答案
) engine=InnoDB;

# 已经发布的问卷
create table que_pub (
    qid           int not null,                       # 问卷原型id
    sch_year      varchar(80),                        # 学年
    sch_term      int,                                # 学期
    sch_day       int,                                # 工作日
    sch_tim       varchar(80)                         # 工作时段
) engine=InnoDB;

# 小测or问卷答案统计
create table que_a_sta (
    queid         varchar(80) not null,               # 问题id
    aid           varchar(80) not null,               # 答案id
    count         int not null,                       # 多少人填
    ratio         float                               # 占比例
) engine=InnoDB;

# 留言表
create table msg (
    src_id        int not null,                       # 源id
    dst_id        int not null,                       # 宿id
    msg           varchar(80) not null,               # 留言内容
    tim_send      datetime,                           # 发送时间
    tim_read      datetime,                           # 阅读时间
    stat          varchar(10) default '未读'           # 阅读状态
) engine=InnoDB;

alter table course add foreign key fk_course_tea(tea_id) references tea(id);
alter table stu add foreign key fk_stu_course(course_id) references course(id);
alter table grp add foreign key fk_grp_course(course_id) references course(id);
alter table sign_stu add foreign key fb_sign_stu_stu(id,course_id) references stu(id,course_id);
alter table sign_stu add foreign key fb_sign_stu_ip(ip) references ip(ip);
alter table sign_ta add foreign key fb_sign_ta_ta(id) references ta(id);
alter table excp_submit add foreign key fb_excp_submit_stu(stu_id) references stu(id);