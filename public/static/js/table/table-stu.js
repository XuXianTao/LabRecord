jQuery(function($){
    jQuery('#table-stu').bootstrapTable({
        height: $(window).height() - 120,
        striped: true,        // 隔行变色
        sortName: 'id',
        sortOrder: 'desc',
        method: 'post',
        url: "{:Url('Table/table_stu')}",
        pagination: true,
        sidePagination: 'client',    //设置在哪里进行分页，client=>客户端
        pageNumber: 1,        // 首页页码
        pageSize: 10,        // 页面数据条数
        pageList:  [10, 25, 50, 101, 'All'],
        search: true,        // 启用搜索框
        searchTimeOut: 500,        // 设置搜索超时时间
        showRefresh: true,        // 显示刷新按钮
        showPaginationSwitch: true,        // 是否显示条数选择框
        queryParams: function (params) {
            return {
                limit: params.limit,
                offset: params.offset,
                search: params.search,
                sort: params.sort,
                order: params.order
            };
        }
    });
});