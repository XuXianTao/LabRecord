drop database if exists `LabRecord`;
create database `LabRecord` character set utf8;
use `LabRecord`;
# IP、座位号映像
create table ip (
    ip            varchar(80) not null primary key,  # ip地址
    cla           varchar(80) not null,              # 课室号
    num           varchar(80) not null               # 桌号
) engine=InnoDB;

# 学生
create table stu (
    id            int not null,                      # 学号
    nam           varchar(80) not null,              # 名字
    cla           varchar(80),                       # 课室
    tea_id        int not null,                      # 上课教师职工号
    sch_year      varchar(80) not null,              # 学年
    sch_term      int not null,                      # 学期
    sch_day       int not null,                      # 上课日，1一，2二...
    sch_tim       varchar(80) not null,              # 上课时段
    primary key(id,sch_year,sch_term,sch_day,sch_tim)
) engine=InnoDB;

# 管理、教师、助理
create table admin (
    typ           int not null,                      # 类型，0管理，1教师，2助理
    id            int not null,                      # 职工号/学号
    nam           varchar(80) not null,              # 名字
    cla           varchar(80),                       # 课室
    sch_year      varchar(80),                       # 学年
    sch_term      int,                               # 学期
    sch_day       int,                               # 工作日，1一，2二
    sch_tim       varchar(80),                       # 工作时段
    primary key(typ,id,sch_year,sch_term,cla,sch_day,sch_tim)
) engine=InnoDB;

#签到表-stu
create table sign_stu (
    id            int not null,                      # 学号
    sign_in       datetime,                          # 签到/登入时间
    sign_out      datetime,                          # 登出时间
    statu         boolean,                           # 缺勤？
    week          int not null,                      # 签到周数
    day           int not null                       # 签到天数
) engine=InnoDB;

#签到表-ta
create table sign_ta (
    id            int not null,                      # 学号
    sign_in       datetime,                          # 签到/登入时间
    sign_out      datetime,                          # 登出时间
    statu         boolean,                           # 缺勤？
    week          int not null,                      # 签到周数
    day           int not null,                      # 签到天数
    duty_time     datetime                           # 当天执勤时长
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

