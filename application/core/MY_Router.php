<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Router extends CI_Router {

    /**
     * 个人认为比较完美解决问题的方法
     */
    protected function _set_default_controller() {
         
        if (empty($this->default_controller)) {
            
            show_error('Unable to determine what should be displayed. A default route has not been specified in the routing file.');
        }

        if (sscanf($this->default_controller, '%[^/]/%s', $class, $method) !== 2) {
            $method = 'index';
        }

        /**
         * 1.判断目录是否存在
         * 2.如果存在 调用设置控制器目录方法 详细参考system/core/Route.php set_directory方法
         * 3.接着再把method拆分 赋值给$class $method $method为空则设置为index
         */
        if( is_dir(APPPATH.'controllers/'.$class) ) {
             
            // Set the class as the directory
            $this->set_directory($class);
            
            // $method is the class
            $class = $method;
            
            // Re check for slash if method has been set
            if (sscanf($method, '%[^/]/%s', $class, $method) !== 2) {
                $method = 'index';
            }
        }

        if ( ! file_exists(APPPATH.'controllers/'.$this->directory.ucfirst($class).'.php')) {
            // This will trigger 404 later
            return;
        }

        $this->set_class($class);
        $this->set_method($method);

        // Assign routed segments, index starting from 1
        $this->uri->rsegments = array(
            1 => $class,
            2 => $method
        );
        log_message('debug', 'No URI present. Default controller set.');
    }

    /**
     * @author 命中水、 
     * @date(2017-8-7)
     * 
     * 使用这个方法时 把这个方法名和上面的方法名调换一下 
     * application/config/route.php default_controller的值写uri全称(目录名/控制器名/方法名) 即可
     * 因为最终Route.php路由类库调用的还是_set_default_controller方法
     */
    protected function _set_default_controller_me() {
         
        if (empty($this->default_controller))
        {
            show_error('Unable to determine what should be displayed. A default route has not been specified in the routing file.');
        }

        /**
         * if里为自己修改的部分
         * 1.截取default_controller为数组
         * 2.如果default_controller_arr大于3 表示是默认控制器过来的
         * 3.赋值相应的变量
         */
        $default_controller_arr = explode('/', $this->default_controller);
        if(count($default_controller_arr) == 3) {
            // 赋值控制器目录
            $this->directory = trim($default_controller_arr[0], '/') . '/';
            // 赋值控制器名
            $class  = $default_controller_arr[1];
            // 因为这里计划约定默认控制器输入完整uri 即目录名/控制器名/方法名的形式
            // 所以方法名这里一定不为空
            $method = $default_controller_arr[2];

        }else {
            if (sscanf($this->default_controller, '%[^/]/%s', $class, $method) !== 2)
            {
                $method = 'index';
            }
        }
        if ( ! file_exists(APPPATH.'controllers/'.$this->directory.ucfirst($class).'.php'))
        {
            // This will trigger 404 later
            return;
        }

        $this->set_class($class);
        $this->set_method($method);

        // Assign routed segments, index starting from 1
        $this->uri->rsegments = array(
            1 => $class,
            2 => $method
        );

        log_message('debug', 'No URI present. Default controller set.');
    }

}