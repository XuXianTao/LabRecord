drop database if exists `LabRecord`;
create database `LabRecord` character set utf8;
use `LabRecord`;

# 当前周数，星期几
create table the_date(
    id            int not null primary key,
    week          int not null default 1,
    day           int not null default 1,
    start_date    int
) engine=InnoDB;
use `LabRecord`;
insert into the_date(id,week,start_date) values (1,1,1);
# IP、座位号映像
create table ip (
    ip            varchar(80) not null primary key,  # ip地址
    room          varchar(80) not null,              # 课室号
    num           varchar(80) not null               # 桌号
) engine=InnoDB;

# 课程
create table course (
    id            int not null primary key auto_increment,
                                                     # 课程id
    name          varchar(80) not null,              # 课程名称
    cla           varchar(80) not null,              # 课室号
    tea_id        int not null,                      # 老师id
    sch_time_start time not null,                    # 上课时间
    sch_time_end   time not null,                    # 下课时间
    sch_year      varchar(80),                       # 学年
    sch_term      int,                               # 学期
    sch_day       varchar(10),                       # 工作日
    sch_week_start int                               # 第几周开始上课
) auto_increment=1 engine=InnoDB;
# 学生
create table stu (
    id            int not null,                      # 学号
    name          varchar(80) not null,              # 名字
    course_id     int not null,                      # 课程id
    primary key(id,course_id)
) engine=InnoDB;

# TA实验室助理
create table ta (
    id            int not null primary key,          # 学号
    name          varchar(80) not null,              # 姓名
    sch_year      varchar(80),                       # 学年
    sch_term      int,                               # 学期
    sch_time      varchar(80)                        # 具体时间-仅用作描述
) engine=InnoDB;
# 管理老师、上课老师
create table teacher (
    type          int not null,                      # 类型，0管理，1管理老师，2上课老师
    id            int not null,                      # 职工号
    name          varchar(80) not null,              # 名字
    primary key(type,id)
) engine=InnoDB;

#签到表-stu
create table sign_stu (
    id            int not null,                      # 学号
    name          varchar(80) not null,
    sign_in       datetime,                          # 签到/登入时间
    sign_out      datetime,                          # 登出时间
    statu         varchar(80),                       # 缺勤？
    week          int not null,                      # 签到周数
    day           int not null                       # 签到天数
) engine=InnoDB;

#签到表-ta
create table sign_ta (
    id            int not null,                      # 学号
    name          varchar(80) not null,
    sign_in       datetime,                          # 签到/登入时间
    sign_out      datetime,                          # 登出时间
    statu         varchar(80),                       # 缺勤？
    week          int not null,                      # 签到周数
    day           int not null,                      # 签到天数
    duty_time     int default 0                      # 当天执勤时长
) engine=InnoDB;

#问卷or小测
create table que (
    qid           int not null primary key auto_increment,
                                                     # 问卷ID
    amount        int not null,                      # 问题个数
    title         varchar(80) not null               # 问卷标题
) auto_increment=1 engine=InnoDB;

#问题
create table que_q (
    qid           int not null,                      # 问卷id
    num           int not null,                      # 第几个问题
    queid         varchar(80) not null primary key,  # id_num
    que           varchar(80) not null,              # 问题
    type          varchar(80) not null               # 问卷or小测
) engine=InnoDB;

#答案
create table que_a (
    queid         varchar(80) not null,              # 问题id
    num           int not null,                      # 第几个答案
    aid           varchar(80) not null primary key,  # queid_num
    ans           varchar(80) not null,              # 回答内容
    correct       boolean default false              # 是否正确答案
) engine=InnoDB;

#已经发布的问卷
create table que_pub (
    qid           int not null,                      # 问卷原型id
    sch_year      varchar(80),                       # 学年
    sch_term      int,                               # 学期
    sch_day       int,                               # 工作日
    sch_tim       varchar(80)                        # 工作时段
) engine=InnoDB;

#小测or问卷答案统计
create table que_a_sta (
    queid         varchar(80) not null,              # 问题id
    aid           varchar(80) not null,              # 答案id
    count         int not null,                      # 多少人填
    ratio         float                              # 占比例
) engine=InnoDB;
#ratio的自适应还是php写吧

