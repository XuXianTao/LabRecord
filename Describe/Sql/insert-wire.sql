/*
create table wire (
    kind          varchar(20) not null,               # 配线种类
    appar         varchar(20) not null,               # 配套仪器
    color         varchar(10) not null,               # 颜色
    num           int not null default 1              # 数量
) engine=InnoDB;
*/
insert into wire(kind,appar,color,num) values('220V电源线','实验箱','黑','1');

insert into wire(kind,appar,color,num) values('强电连接线','交流实验箱','黑','4');
insert into wire(kind,appar,color,num) values('强电连接线','交流实验箱','红','4');
insert into wire(kind,appar,color,num) values('强电连接线','交流实验箱','黄','4');
insert into wire(kind,appar,color,num) values('强电连接线','交流实验箱','绿','4');

insert into wire(kind,appar,color,num) values('直流电源线','直流电源','黑','1');
insert into wire(kind,appar,color,num) values('直流电源线','直流电源','红','1');
insert into wire(kind,appar,color,num) values('直流电源线','直流电源','蓝','1');
insert into wire(kind,appar,color,num) values('直流电源线','直流电源','绿','1');
insert into wire(kind,appar,color,num) values('直流电源线','直流电源','黄','2');

insert into wire(kind,appar,color,num) values('表笔','台式万用表','红','1');
insert into wire(kind,appar,color,num) values('表笔','台式万用表','黑','1');
insert into wire(kind,appar,color,num) values('热电偶温度传感器','台式万用表','灰','1');

insert into wire(kind,appar,color,num) values('功率表连接线','功率表','红','1');
insert into wire(kind,appar,color,num) values('功率表连接线','功率表','黑','1');
insert into wire(kind,appar,color,num) values('功率表连接线','功率表','黄','1');

insert into wire(kind,appar,color,num) values('测试探头','数字示波器','黑','2');

insert into wire(kind,appar,color,num) values('BNC转鳄鱼夹','函数发生器','黑','2');

insert into wire(kind,appar,color,num) values('电流测量线','实验箱','白','2');

insert into wire(kind,appar,color,num) values('2号信号线','实验箱','黑','4');
insert into wire(kind,appar,color,num) values('2号信号线','实验箱','红','8');
insert into wire(kind,appar,color,num) values('2号信号线','实验箱','蓝','8');
insert into wire(kind,appar,color,num) values('2号信号线','实验箱','绿','8');
insert into wire(kind,appar,color,num) values('2号信号线','实验箱','黄','8');
