/*
create table stu (
    id            int not null primary key,          # 学号
    nam           varchar(80) not null,              # 名字
    sch_year       varchar(80) not null,              # 学年
    sch_term       int not null,                      # 学期
    sch_day        int not null,                      # 上课日，1一，2二...
    sch_tim        varchar(80) not null,              # 上课时段
    tea_id         int not null,                      # 上课教师职工号
    foreign key(tea_id) references man(id)
) engine=InnoDB;
*/
use `LabRecord`;

insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16000000','STU','2017-2018','2','1','3-4节(10:00-11:40)','100000');

insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301004','蔡泽帆','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301005','曹杰全','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301009','陈炳旭','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301014','陈天怡','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301017','陈志豪','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301019','邓常晖','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301020','邓闻达','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301023','丁正卿','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301027','方宇蔚','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301029','冯秋霞','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301035','郭宜阁','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301038','何洛','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301043','何远聪','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301047','黄嘉麟','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301048','黄镁铃','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301051','黃騫禾','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301053','惠霄菲','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301056','康生晶','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301057','柯圣学','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301058','孔晨光','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301063','李慧怡','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301071','李玉军','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301076','林睿希','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301079','林智强','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301080','刘宏虎','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301081','刘嘉文','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301083','刘炯利','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301086','刘璐','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301087','刘奇','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301089','刘星晨','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301090','刘依萍','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301093','卢可欣','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301095','罗红雨','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301096','罗翊','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301102','麦朝旭','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301107','彭升','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301108','彭书吟','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301109','齐蒙','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301115','沈敏慧','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301116','史宛琪','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301118','孙晨博','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301120','孙鑫源','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301121','谭添文','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301122','谭文','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301123','唐鲲鹏','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301127','王彬','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301141','吴震乾','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301142','吴作杰','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301145','肖剑涛','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301147','谢明振','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301148','谢逸隆','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301149','谢钰霖','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301150','谢展鹏','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301151','谢沚昂','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301168','袁玥','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16326110','张靖楠','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301178','张梓哲','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301179','张宗英','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301181','赵逸凡','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301187','周毅','2017-2018','2','2','5-6节(14:20-16:00)','100001');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301193','邹典廷','2017-2018','2','2','5-6节(14:20-16:00)','100001');

insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301003','蔡林珂','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301008','常嘉倪','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301010','陈富斌','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301011','陈佳雄','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301012','陈思帆','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301021','邓云洁','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301025','范俊呈','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301026','范贤婷','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301030','高恒','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301033','桂文涛','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301039','何舒然','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301044','何镇航','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301045','胡文仪','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301046','胡雨欣','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301049','黄思聪','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301052','惠蒙飞','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301055','蒋素秋','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301060','黎浩然','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301062','李兵','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301065','李秋鹏','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301069','李怡贤','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301072','李志峰','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301073','利文杰','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301082','刘竞妍','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301085','刘靓琳','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301097','吕楚滢','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301099','马骏驰','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301104','欧炽毅','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301117','苏沛锋','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301124','陶文杰','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301129','王进卿','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301131','王胜','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301132','王天羿','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301133','王亚文','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301135','韦慧叶','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301136','魏聪','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301139','吴鸿鑫','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301140','吴宇恒','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301144','武金艺','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301154','徐玉淳','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301156','薛香','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301159','杨欣茹','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301160','杨映荷','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301161','杨宇恒','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301163','杨泽淳','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301165','叶浚宏','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301166','尹静瑶','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301167','尹柳','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301169','张安宇','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301170','张家诚','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301171','张劲峰','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301173','张可欣','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301175','张太霖','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301182','郑鸿雪阳','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301184','钟桂豪','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301185','周梦楠','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301186','周贤霖','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301188','朱浩林','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301191','朱雅洁','2017-2018','2','3','5-6节(14:20-16:00)','100002');
insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16301192','朱泳澜','2017-2018','2','3','5-6节(14:20-16:00)','100002');

insert into stu(`id`,`nam`,`sch_year`,`sch_term`,`sch_day`,`sch_tim`,`tea_id`) values('16000001','STU','2017-2018','2','4','3-4节(10:00-11:40)','100003');

select * from stu order by id,tea_id ASC;