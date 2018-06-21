/*
* create table excp_static (
*   lid         int not null,
*   typ         varchar(80) not null,
*   machine     varchar(80) not null,
*   color       varchar(80) not null,
*   num         int
* ) engine=InnoDB;
*/
insert into excp_static(lid, typ, machine, color, num) values(1, '220V电源线', '实验箱', '黑', 1);

insert into excp_static(lid, typ, machine, color, num) values(2, '强电连接线', '交流实验箱', '黑', 4);
insert into excp_static(lid, typ, machine, color, num) values(2, '强电连接线', '交流实验箱', '红', 4);
insert into excp_static(lid, typ, machine, color, num) values(2, '强电连接线', '交流实验箱', '黄', 4);
insert into excp_static(lid, typ, machine, color, num) values(2, '强电连接线', '交流实验箱', '绿', 4);

insert into excp_static(lid, typ, machine, color, num) values(3, '直流电源线', '直流稳压电源', '黑', 1);
insert into excp_static(lid, typ, machine, color, num) values(3, '直流电源线', '直流稳压电源', '红', 1);
insert into excp_static(lid, typ, machine, color, num) values(3, '直流电源线', '直流稳压电源', '蓝', 1);
insert into excp_static(lid, typ, machine, color, num) values(3, '直流电源线', '直流稳压电源', '绿', 1);
insert into excp_static(lid, typ, machine, color, num) values(3, '直流电源线', '直流稳压电源', '黄', 2);

insert into excp_static(lid, typ, machine, color, num) values(4, '表笔', '台式万用表', '红', 1);
insert into excp_static(lid, typ, machine, color, num) values(4, '表笔', '台式万用表', '黑', 1);

insert into excp_static(lid, typ, machine, color, num) values(5, '功率表连接线', '功率表', '红', 1);
insert into excp_static(lid, typ, machine, color, num) values(5, '功率表连接线', '功率表', '黑', 1);
insert into excp_static(lid, typ, machine, color, num) values(5, '功率表连接线', '功率表', '黄', 1);

insert into excp_static(lid, typ, machine, color, num) values(6, '测试探头', '数字示波器', '黑', 2);

insert into excp_static(lid, typ, machine, color, num) values(7, 'BNC转鳄鱼夹', '函数信号发生器', '黑', 2);

insert into excp_static(lid, typ, machine, color, num) values(8, '热电偶温度传感器', '台式万用表', '灰', 1);

insert into excp_static(lid, typ, machine, color, num) values(9, '电流测量线', '实验箱', '白', 2);

insert into excp_static(lid, typ, machine, color, num) values(10, '2号信号线', '实验箱', '黑', 4);
insert into excp_static(lid, typ, machine, color, num) values(10, '2号信号线', '实验箱', '红', 8);
insert into excp_static(lid, typ, machine, color, num) values(10, '2号信号线', '实验箱', '蓝', 8);
insert into excp_static(lid, typ, machine, color, num) values(10, '2号信号线', '实验箱', '绿', 8);
insert into excp_static(lid, typ, machine, color, num) values(10, '2号信号线', '实验箱', '黄', 8);

insert into excp_static(lid, typ, machine, color, num) values(11, '主机', '主机', '主机', 8);
insert into excp_static(lid, typ, machine, color, num) values(12, '显示器', '显示器', '显示器', 8);