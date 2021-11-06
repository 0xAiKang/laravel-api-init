<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSystemMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::create('system_menu', function (Blueprint $table) {
            $table->id();
            $table->integer("pid")->comment("父级ID");
            $table->tinyInteger("type")->comment("菜单类型（1.菜单、2.按钮/权限）");
            $table->string("target")->comment("打开方式：_blank、_self、_parent、_top");
            $table->string("title")->comment("按钮名称");
            $table->string("name")->comment("路由名称");
            $table->string("icon")->comment("图标");
            $table->string("path")->comment("路由");
            $table->string("component")->comment("前端组件");
            $table->string("redirect")->comment("默认重定向路径，有子节点的菜单才有");
            $table->string("controller")->comment("控制器");
            $table->string("action")->comment("方法名");
            $table->string("method")->comment("请求方式")->default("get");
            $table->string("api")->comment("API地址");
            $table->string("params")->comment("参数")->default("[]");
            $table->smallInteger("sort")->comment("排序")->default(0);
            $table->integer("permission_id")->comment("权限ID")->default(0);
            $table->tinyInteger("status")->comment("状态")->default(1);
            $table->tinyInteger("is_deleted")->comment("是否删除");
            $table->timestamps();
        });*/

        $createTableSql = "CREATE TABLE `system_menu` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单ID',
              `pid` int(11) unsigned DEFAULT '0' COMMENT '父级id',
              `type` tinyint(1) NOT NULL COMMENT '菜单类型 1菜单、2：按钮/权限',
              `target` varchar(10) NOT NULL DEFAULT '' COMMENT '打开方式：_blank、_self、_parent、_top',
              `title` varchar(32) NOT NULL DEFAULT '' COMMENT '按钮名',
              `name` varchar(64) DEFAULT '' COMMENT '路由名称',
              `icon` varchar(32) NOT NULL DEFAULT '' COMMENT '图标',
              `path` varchar(255) NOT NULL DEFAULT '' COMMENT '路由',
              `component` varchar(100) NOT NULL DEFAULT '' COMMENT '前端组件',
              `redirect` varchar(255) NOT NULL DEFAULT '' COMMENT '默认重定向路径，有子节点的菜单才有',
              `controller` varchar(64) NOT NULL DEFAULT '' COMMENT '控制器',
              `action` varchar(32) NOT NULL DEFAULT '' COMMENT '方法名',
              `method` varchar(100) DEFAULT 'get' COMMENT '请求方式',
              `api` varchar(255) NOT NULL DEFAULT '' COMMENT 'API地址',
              `params` varchar(128) NOT NULL DEFAULT '[]' COMMENT '参数',
              `sort` smallint(11) DEFAULT '0' COMMENT '排序字段 正序',
              `permission_id` int(11) DEFAULT '0' COMMENT '权限ID',
              `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
              `is_deleted` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
              `created_at` timestamp NULL DEFAULT NULL,
              `updated_at` timestamp NULL DEFAULT NULL,
              PRIMARY KEY (`id`),
              UNIQUE KEY `id` (`id`) USING BTREE,
              UNIQUE KEY `permission_id` (`permission_id`) USING BTREE,
              KEY `pid` (`pid`) USING BTREE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='菜单表';";

        DB::statement($createTableSql);

        $sql = "INSERT INTO `system_menu` (`id`, `pid`, `type`, `target`, `title`, `name`, `icon`, `path`, `component`, `redirect`, `controller`, `action`, `method`, `api`, `params`, `sort`, `permission_id`, `status`, `is_deleted`, `created_at`, `updated_at`)
        VALUES
            (7, 0, 1, '', '数据看板', '', 'icon-zhuye', '/index', 'Layout', '/index', '', '', 'get', '', '\'{\"isRouter\": \"true\"}\'', 1, 8, 1, 0, '2021-06-22 19:34:47', '2021-09-15 09:40:38'),
            (44, 0, 1, '', '系统管理', '', 'icon-xitong', '/system', 'Layout', '/system/list', '', '', 'get', '', '[]', 8, 46, 1, 0, '2021-09-09 17:59:44', '2021-09-15 09:41:41'),
            (45, 44, 1, '', '管理员', '', '|--', '/system/admin', '/system/admin', '', '', '', 'get', '', '', 0, 47, 1, 0, '2021-09-09 18:00:23', '2021-09-17 13:56:27'),
            (46, 44, 1, '', '菜单管理', '', '|--', '/system/menu', '/system/menu', '', '', '', 'get', '', '[]', 0, 48, 1, 0, '2021-09-09 18:00:41', '2021-09-13 16:32:13'),
            (48, 44, 1, '', '角色管理', '', '|--', '/system/character', '/system/character', '', '', '', 'get', '', '[]', 0, 50, 1, 0, '2021-09-09 18:01:58', '2021-09-22 18:32:20');";

        DB::statement($sql);

        $sql2 = "INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`)
        VALUES
	        (8, '管理员', 'admin', '2021-09-10 17:28:26', '2021-09-10 17:28:26');";

        DB::statement($sql2);

        $sql4 = "INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`)
VALUES
	(8, '所有', 'admin', '2021-06-22 19:34:47', '2021-06-22 19:34:47'),
	(46, '系统管理', 'admin', '2021-09-09 17:59:44', '2021-09-09 17:59:44'),
	(47, '管理员', 'admin', '2021-09-09 18:00:23', '2021-09-09 18:00:23'),
	(48, '菜单管理', 'admin', '2021-09-09 18:00:41', '2021-09-09 18:00:41'),
	(50, '权限管理', 'admin', '2021-09-09 18:01:58', '2021-09-09 18:01:58');
";
        DB::statement($sql4);

        $sql3 = "INSERT INTO `role_has_permissions` (`permission_id`, `role_id`)
        VALUES
            (8, 8),
            (46, 8),
            (47, 8);";

        DB::statement($sql3);

        $sql5 = "INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`)
VALUES
	(8, 'App\\Models\\Admin\\AdminModel', 1),
	(8, 'App\\Models\\Admin\\AdminModel', 2),
	(8, 'App\\Models\\AdminModel', 2),
	(8, 'App\\Models\\Admin\\AdminModel', 3),
	(8, 'App\\Models\\Admin\\AdminModel', 9);
";

        DB::statement($sql5);

        $sql6 = "INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`)
VALUES
	(8, 'App\\Models\\Admin\\AdminModel', 1),
	(8, 'App\\Models\\Admin\\AdminModel', 2);
";

        DB::statement($sql6);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_menu');
    }
}
