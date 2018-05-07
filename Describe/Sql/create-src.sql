drop database if exists `lab_sys`;
create database `lab_sys` character set utf8;
use `lab_sys`;

# IP、座位号映像
create table ip (
    ip            varchar(80) not null primary key,  # ip地址
    cla           varchar(80) not null,              # 课室号
    num           varchar(80) not null               # 桌号
) engine=InnoDB;
# 管理、教师、助理
create table man (
    typ           int not null,                      # 类型，0管理，1教师，2助理
    id            int not null,                      # 职工号/学号
    nam           varchar(80) not null,              # 名字
    schYear       varchar(80),                       # 学年
    schTerm       int,                               # 学期
    cla           varchar(80),                       # 课室
    schDay        int,                               # 工作日，1一，2二
    schTim        varchar(80),                       # 工作时段
    primary key(typ,id,schYear,schTerm,cla,schDay,schTim)
) engine=InnoDB;
# 学生
create table stu (
    id            int not null primary key,          # 学号
    nam           varchar(80) not null,              # 名字
    schYear       varchar(80) not null,              # 学年
    schTerm       int not null,                      # 学期
    schDay        int not null,                      # 上课日，1一，2二...
    schTim        varchar(80) not null,              # 上课时段
    teaId         int not null                       # 上课教师职工号
) engine=InnoDB;

# 原始问卷
create table fbori (
    id            int primary key auto_increment,    # 问卷id
    creTim        datetime,                          # 创建时间
    teaId         int,                               # 创建人id
    teaNam        varchar(80),                       # 创建人名字
    typ           tinyint default 0,                 # 问卷类型：0调查问卷，1课堂小测
    tit           varchar(80) default null,          # 问卷标题
    q1            varchar(80) default null,          # 问题1
    a1_q1         varchar(80) default null,          # 问题1第一选项
    a2_q1         varchar(80) default null,          # 问题1第二选项
    a3_q1         varchar(80) default null,          # 问题1第三选项
    a4_q1         varchar(80) default null,          # 问题1第四选项
    a5_q1         varchar(80) default null,          # 问题1第五选项
    a_q1          int default null,                  # 问题1正确选项
    q2            varchar(80) default null,          # 问题2
    a1_q2         varchar(80) default null,          # 问题2第一选项
    a2_q2         varchar(80) default null,          # 问题2第二选项
    a3_q2         varchar(80) default null,          # 问题2第三选项
    a4_q2         varchar(80) default null,          # 问题2第四选项
    a5_q2         varchar(80) default null,          # 问题2第五选项
    a_q2          int default null,                  # 问题2正确选项
    q3            varchar(80) default null,          # 问题3
    a1_q3         varchar(80) default null,          # 问题3第一选项
    a2_q3         varchar(80) default null,          # 问题3第二选项
    a3_q3         varchar(80) default null,          # 问题3第三选项
    a4_q3         varchar(80) default null,          # 问题3第四选项
    a5_q3         varchar(80) default null,          # 问题3第五选项
    a_q3          int default null,                  # 问题3正确选项
    q4            varchar(80) default null,          # 问题4
    a1_q4         varchar(80) default null,          # 问题4第一选项
    a2_q4         varchar(80) default null,          # 问题4第二选项
    a3_q4         varchar(80) default null,          # 问题4第三选项
    a4_q4         varchar(80) default null,          # 问题4第四选项
    a5_q4         varchar(80) default null,          # 问题4第五选项
    a_q4          int default null,                  # 问题4正确选项
    q5            varchar(80) default null,          # 问题5
    a1_q5         varchar(80) default null,          # 问题5第一选项
    a2_q5         varchar(80) default null,          # 问题5第二选型
    a3_q5         varchar(80) default null,          # 问题5第三选项
    a4_q5         varchar(80) default null,          # 问题5第四选项
    a5_q5         varchar(80) default null,          # 问题5第五选项
    a_q5          int default null,                  # 问题5正确选项
    q6            varchar(80) default null,          # 问题6
    a1_q6         varchar(80) default null,          # 问题6第一选项
    a2_q6         varchar(80) default null,          # 问题6第二选型
    a3_q6         varchar(80) default null,          # 问题6第三选项
    a4_q6         varchar(80) default null,          # 问题6第四选项
    a5_q6         varchar(80) default null,          # 问题6第五选项
    a_q6          int default null,                  # 问题6正确选项
    q7            varchar(80) default null,          # 问题7
    a1_q7         varchar(80) default null,          # 问题7第一选项
    a2_q7         varchar(80) default null,          # 问题7第二选型
    a3_q7         varchar(80) default null,          # 问题7第三选项
    a4_q7         varchar(80) default null,          # 问题7第四选项
    a5_q7         varchar(80) default null,          # 问题7第五选项
    a_q7          int default null,                  # 问题7正确选项
    q8            varchar(80) default null,          # 问题8
    a1_q8         varchar(80) default null,          # 问题8第一选项
    a2_q8         varchar(80) default null,          # 问题8第二选型
    a3_q8         varchar(80) default null,          # 问题8第三选项
    a4_q8         varchar(80) default null,          # 问题8第四选项
    a5_q8         varchar(80) default null,          # 问题8第五选项
    a_q8          int default null,                  # 问题8正确选项
    q9            varchar(80) default null,          # 问题9
    a1_q9         varchar(80) default null,          # 问题9第一选项
    a2_q9         varchar(80) default null,          # 问题9第二选型
    a3_q9         varchar(80) default null,          # 问题9第三选项
    a4_q9         varchar(80) default null,          # 问题9第四选项
    a5_q9         varchar(80) default null,          # 问题9第五选项
    a_q9          int default null,                  # 问题9正确选项
    q10           varchar(80) default null,          # 问题10
    a1_q10        varchar(80) default null,          # 问题10第一选项
    a2_q10        varchar(80) default null,          # 问题10第二选型
    a3_q10        varchar(80) default null,          # 问题10第三选项
    a4_q10        varchar(80) default null,          # 问题10第四选项
    a5_q10        varchar(80) default null,          # 问题10第五选项
    a_q10         int default null                   # 问题10正确选项
) auto_increment=1 engine=InnoDB;
# 已发布问卷
create table fbrls (
    id            int primary key auto_increment,    # 问卷id
    teaId         int not null,                      # 发布者id
    teaNam        varchar(80) not null,              # 发布者名字
    rlsTim        datetime,                          # 发布时间
    ddl           datetime,                          # 截止时间
    typ           tinyint default 0,                 # 问卷类型：0调查问卷，1课堂小测
    schYear       varchar(80) not null,              # 问卷发放到的班级的对应学年
    schTerm       int not null,                      # 问卷发放到班级的对应学期
    cla           varchar(80) not null,              # 问卷发放到的班级的所在课室
    schDay        int,                               # 问卷发放到的班级的对应上课日，1一，2二
    schTim        varchar(80),                       # 问卷发放到的班级的上课时段
    fillNum       int default 0,                     # 问卷已填写人数
    tit           varchar(80) default null,          # 问卷标题
    q1            varchar(80) default null,          # 问题1
    a1_q1         varchar(80) default null,          # 问题1第一选项
    a1_q1_Num     int default 0,                     # 问题1第一选项选中人数
    a2_q1         varchar(80) default null,          # 问题1第二选项
    a2_q1_Num     int default 0,                     # 问题1第二选项选中人数
    a3_q1         varchar(80) default null,          # 问题1第三选项
    a3_q1_Num     int default 0,                     # 问题1第三选项选中人数
    a4_q1         varchar(80) default null,          # 问题1第四选项
    a4_q1_Num     int default 0,                     # 问题1第四选项选中人数
    a5_q1         varchar(80) default null,          # 问题1第五选项
    a5_q1_Num     int default 0,                     # 问题1第五选项选中人数
    a_q1          int,                               # 问题1正确选项
    a_q1_Num      int default 0,                     # 问题1正确选项选中人数
    q2            varchar(80) default null,          # 问题2
    a1_q2         varchar(80) default null,          # 问题2第一选项
    a1_q2_Num     int default 0,                     # 问题2第一选项选中人数
    a2_q2         varchar(80) default null,          # 问题2第二选项
    a2_q2_Num     int default 0,                     # 问题2第二选项选中人数
    a3_q2         varchar(80) default null,          # 问题2第三选项
    a3_q2_Num     int default 0,                     # 问题2第三选项选中人数
    a4_q2         varchar(80) default null,          # 问题2第四选项
    a4_q2_Num     int default 0,                     # 问题2第四选项选中人数
    a5_q2         varchar(80) default null,          # 问题2第五选项
    a5_q2_Num     int default 0,                     # 问题2第五选项选中人数
    a_q2          int,                               # 问题2正确选项
    a_q2_Num      int default 0,                     # 问题2正确选项选中人数
    q3            varchar(80) default null,          # 问题3
    a1_q3         varchar(80) default null,          # 问题3第一选项
    a1_q3_Num     int default 0,                     # 问题3第一选项选中人数
    a2_q3         varchar(80) default null,          # 问题3第二选项
    a2_q3_Num     int default 0,                     # 问题3第二选项选中人数
    a3_q3         varchar(80) default null,          # 问题3第三选项
    a3_q3_Num     int default 0,                     # 问题3第三选项选中人数
    a4_q3         varchar(80) default null,          # 问题3第四选项
    a4_q3_Num     int default 0,                     # 问题3第四选项选中人数
    a5_q3         varchar(80) default null,          # 问题3第五选项
    a5_q3_Num     int default 0,                     # 问题3第五选项选中人数
    a_q3          int,                               # 问题3正确选项
    a_q3_Num      int default 0,                     # 问题3正确选项选中人数
    q4            varchar(80) default null,          # 问题4
    a1_q4         varchar(80) default null,          # 问题4第一选项
    a1_q4_Num     int default 0,                     # 问题4第一选项选中人数
    a2_q4         varchar(80) default null,          # 问题4第二选项
    a2_q4_Num     int default 0,                     # 问题4第二选项选中人数
    a3_q4         varchar(80) default null,          # 问题4第三选项
    a3_q4_Num     int default 0,                     # 问题4第三选项选中人数
    a4_q4         varchar(80) default null,          # 问题4第四选项
    a4_q4_Num     int default 0,                     # 问题4第四选项选中人数
    a5_q4         varchar(80) default null,          # 问题4第五选项
    a5_q4_Num     int default 0,                     # 问题4第五选项选中人数
    a_q4          int,                               # 问题4正确选项
    a_q4_Num      int default 0,                     # 问题4正确选项选中人数
    q5            varchar(80) default null,          # 问题5
    a1_q5         varchar(80) default null,          # 问题5第一选项
    a1_q5_Num     int default 0,                     # 问题5第一选项选中人数
    a2_q5         varchar(80) default null,          # 问题5第二选型
    a2_q5_Num     int default 0,                     # 问题5第二选型选中人数
    a3_q5         varchar(80) default null,          # 问题5第三选项
    a3_q5_Num     int default 0,                     # 问题5第三选项选中人数
    a4_q5         varchar(80) default null,          # 问题5第四选项
    a4_q5_Num     int default 0,                     # 问题5第四选项选中人数
    a5_q5         varchar(80) default null,          # 问题5第五选项
    a5_q5_Num     int default 0,                     # 问题5第五选项选中人数
    a_q5          int,                               # 问题5正确选项
    a_q5_Num      int default 0,                     # 问题5正确选项选中人数
    q6            varchar(80) default null,          # 问题6
    a1_q6         varchar(80) default null,          # 问题6第一选项
    a1_q6_Num     int default 0,                     # 问题6第一选项选中人数
    a2_q6         varchar(80) default null,          # 问题6第二选型
    a2_q6_Num     int default 0,                     # 问题6第二选型选中人数
    a3_q6         varchar(80) default null,          # 问题6第三选项
    a3_q6_Num     int default 0,                     # 问题6第三选项选中人数
    a4_q6         varchar(80) default null,          # 问题6第四选项
    a4_q6_Num     int default 0,                     # 问题6第四选项选中人数
    a5_q6         varchar(80) default null,          # 问题6第五选项
    a5_q6_Num     int default 0,                     # 问题6第五选项选中人数
    a_q6          int,                               # 问题6正确选项
    a_q6_Num      int default 0,                     # 问题6正确选项选中人数
    q7            varchar(80) default null,          # 问题7
    a1_q7         varchar(80) default null,          # 问题7第一选项
    a1_q7_Num     int default 0,                     # 问题7第一选项选中人数
    a2_q7         varchar(80) default null,          # 问题7第二选型
    a2_q7_Num     int default 0,                     # 问题7第二选型选中人数
    a3_q7         varchar(80) default null,          # 问题7第三选项
    a3_q7_Num     int default 0,                     # 问题7第三选项选中人数
    a4_q7         varchar(80) default null,          # 问题7第四选项
    a4_q7_Num     int default 0,                     # 问题7第四选项选中人数
    a5_q7         varchar(80) default null,          # 问题7第五选项
    a5_q7_Num     int default 0,                     # 问题7第五选项选中人数
    a_q7          int,                               # 问题7正确选项
    a_q7_Num      int default 0,                     # 问题7正确选项选中人数
    q8            varchar(80) default null,          # 问题8
    a1_q8         varchar(80) default null,          # 问题8第一选项
    a1_q8_Num     int default 0,                     # 问题8第一选项选中人数
    a2_q8         varchar(80) default null,          # 问题8第二选型
    a2_q8_Num     int default 0,                     # 问题8第二选型选中人数
    a3_q8         varchar(80) default null,          # 问题8第三选项
    a3_q8_Num     int default 0,                     # 问题8第三选项选中人数
    a4_q8         varchar(80) default null,          # 问题8第四选项
    a4_q8_Num     int default 0,                     # 问题8第四选项选中人数
    a5_q8         varchar(80) default null,          # 问题8第五选项
    a5_q8_Num     int default 0,                     # 问题8第五选项选中人数
    a_q8          int,                               # 问题8正确选项
    a_q8_Num      int default 0,                     # 问题8正确选项选中人数
    q9            varchar(80) default null,          # 问题9
    a1_q9         varchar(80) default null,          # 问题9第一选项
    a1_q9_Num     int default 0,                     # 问题9第一选项选中人数
    a2_q9         varchar(80) default null,          # 问题9第二选型
    a2_q9_Num     int default 0,                     # 问题9第二选型选中人数
    a3_q9         varchar(80) default null,          # 问题9第三选项
    a3_q9_Num     int default 0,                     # 问题9第三选项选中人数
    a4_q9         varchar(80) default null,          # 问题9第四选项
    a4_q9_Num     int default 0,                     # 问题9第四选项选中人数
    a5_q9         varchar(80) default null,          # 问题9第五选项
    a5_q9_Num     int default 0,                     # 问题9第五选项选中人数
    a_q9          int,                               # 问题9正确选项
    a_q9_Num      int default 0,                     # 问题9正确选项选中人数
    q10           varchar(80) default null,          # 问题10
    a1_q10        varchar(80) default null,          # 问题10第一选项
    a1_q10_Num    int default 0,                     # 问题10第一选项选中人数
    a2_q10        varchar(80) default null,          # 问题10第二选型
    a2_q10_Num    int default 0,                     # 问题10第二选型选中人数
    a3_q10        varchar(80) default null,          # 问题10第三选项
    a3_q10_Num    int default 0,                     # 问题10第三选项选中人数
    a4_q10        varchar(80) default null,          # 问题10第四选项
    a4_q10_Num    int default 0,                     # 问题10第四选项选中人数
    a5_q10        varchar(80) default null,          # 问题10第五选项
    a5_q10_Num    int default 0,                     # 问题10第五选项选中人数
    a_q10         int,                               # 问题10正确选项
    a_q10_Num     int default 0                      # 问题10正确选项选中人数
) auto_increment=1 engine=InnoDB;
# 填写，stu表与fbrls表的联系表，1:n
create table fill (
    stuId         int not null,                      # 学生id
    fbId          int not null,                      # 已发布问卷id
    stat          int not null default 0,            # 学生填写状态，0未填写，1已填写
    cla           varchar(80) not null,              # 课室号
    num           varchar(80) not null,              # 桌号
    scr           int not null default 100,          # 学生分数
    ddl           datetime                           # 截止时间
) engine=InnoDB;

# 异常
create table excp (
    dat           datetime,                          # 时间
    schTim        varchar(80) not null,              # 时间段
    schDay        int not null,                      # 上课日，1一，2二...
    id            int not null,                      # 学号
    nam           varchar(80) not null,              # 名字
    cla           varchar(80) not null,              # 课室
    num           int not null,                      # 桌号
    delId         int,                               # 处理人学号
    delNam        varchar(80),                       # 处理人姓名
    sts           varchar(80) not null,              # 处理状态，完全未处理，处理不成功，处理完毕
    delWay        varchar(80),                       # 处理方式
    delTim        datetime,                          # 处理时间
    pc            boolean,                           # 电脑，0没问题，1有问题
    wire          boolean,                           # 导线，0没问题，1有问题
    box           boolean,                           # 电路箱，0没问题，1有问题
    oscp          boolean,                           # 示波器，0没问题，1有问题
    gen           boolean,                           # 函数发生器，0没问题，1有问题
    oth           boolean,                           # 其他，0没选，1选中
    des           varchar(80),                       # 描述
    primary key(dat,id)
) engine=InnoDB;
# 异常统计
create table excpsta (
    cla           varchar(80) not null,              # 课室
    num           int not null,                      # 桌号
    pc            int default 0,                     # 电脑故障数
    wire          int default 0,                     # 导线故障数
    box           int default 0,                     # 电路箱故障数
    oscp          int default 0,                     # 示波器故障数
    gen           int default 0,                     # 函数发生器故障数
    oth           int default 0                      # 其他故障数
) engine=InnoDB;
create table dev (
    sn            varchar(80) not null primary key,  # 序列号
    cla           varchar(80) not null,              # 所在课室
    num           int not null,              # 当前所在桌号
    typ           int default 1,                     # 类型
    cnt           int default 0                      # 故障数
) engine=InnoDB;
DELIMITER //
create trigger `tri_insert_excpsta_dev` after insert on `excp` for each row
begin
    select count(*) into @cnt from excpsta where cla=new.cla and num=new.num;
    if @cnt<>0 then
        if new.pc<>0 then
            update excpsta set pc=pc+1 where cla=new.cla and num=new.num;
        end if;
        if new.wire<>0 then
            update excpsta set wire=wire+1 where cla=new.cla and num=new.num;
        end if;
        if new.box<>0 then
            update excpsta set box=box+1 where cla=new.cla and num=new.num;
        end if;
        if new.oscp<>0 then
            update excpsta set oscp=oscp+1 where cla=new.cla and num=new.num;
        end if;
        if new.gen<>0 then
            update excpsta set gen=gen+1 where cla=new.cla and num=new.num;
        end if;
        if new.oth<>0 then
            update excpsta set oth=oth+1 where cla=new.cla and num=new.num;
        end if;
    else
        insert into excpsta(cla,num,pc,wire,box,oscp,gen,oth) values(new.cla,new.num,new.pc,new.wire,new.box,new.oscp,new.gen,new.oth);
    end if;
    if new.pc<>0 then
        update dev set cnt=cnt+1 where cla=new.cla and num=new.num and typ=1;
    end if;
    if new.wire<>0 then
        update dev set cnt=cnt+1 where cla=new.cla and num=new.num and typ=2;
    end if;
    if new.box<>0 then
        update dev set cnt=cnt+1 where cla=new.cla and num=new.num and typ=3;
    end if;
    if new.oscp<>0 then
        update dev set cnt=cnt+1 where cla=new.cla and num=new.num and typ=4;
    end if;
    if new.gen<>0 then
        update dev set cnt=cnt+1 where cla=new.cla and num=new.num and typ=5;
    end if;
    if new.oth<>0 then
        update dev set cnt=cnt+1 where cla=new.cla and num=new.num and typ=6;
    end if;
end;
//
DELIMITER ;