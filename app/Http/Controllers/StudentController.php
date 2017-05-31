<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Response;
use Cache;

use App\Jobs\SendEmail;

class StudentController extends Controller
{	

	public function queue(){
		//把任务放到了队列当中
		//在Controller中已经引用了dispatch的类方法
		dispatch(new SendEmail('tangweitao@ccsec.cn'));
	}	

	public function error(){

		abort(503);
	}

	public function cache1(){
		// put 
		// Cache::put('key1','value1',10);
		
		//add 如果不存在则添加成功 存在添加失败返回结果是 一个bool值
		/*$bool = Cache::add('key3','value3',10);	
		var_dump($bool);
		if ($bool) {
		 	return redirect('cache2');
		 } */

		//forever  永久保存cache
		// Cache::forever('key','value');
		

		// has() 判断key是否存在
		// Cache::has('key1');  // 返回的是一个bool值
		

		// pull  将缓存取出来 并且删除
		// Cache::pull('key1')

		//forget  删除
		// Cache::forget('key1'); 
		
	}

	public function cache2(){

		return  Cache::get('key3');
	}
	
		
    public function mail(){
    	//method one to send a eamil
		/*Mail::raw('邮件内容 测试',function($message){
			$message->from('tangwtna@163.com','唐玮涛');
			$message->subject('邮件主题 邮箱测试');
			$message->to('tangweitao@ccsec.cn');
		});*/

		// method two send a email
		Mail::send('welcome',['name'=>'tangweitao'],
			function($message){
				$message->from('tangwtna@163.com','唐玮涛');
				$message->subject('邮件主题 邮箱测试');
				$message->to('tangweitao@ccsec.cn');
			}
			);
	}


    public function uploads(){
    	return 'uploads';
    }

    /**
     * 获取Request请求实例   Laravel中一般通过控制器方法依赖注入来获取当前请求的Request实例。
     * 
     */

    public function getBasetest(Request $request){
    	// 调用Request的时候，要引用命名空间
    	$name = $request->input('name','weitao');
    	echo $name;
    }

   // get request url
   public function getUrl(Request $request){
   		echo '使用$request来获取url'.$request->url();
        echo "<br>";
        echo '使用$request来获取完整的url'.$request->fullUrl();
   		echo "<br>";
   		echo "使用URL类来的url".URL::current();

   }

    // 获取请求的方法
    public function getMethod(Request $request){
    	//不是get请求不能访问
    	echo $request->method();
    	if ($request->isMethod('get')) {
    		dd($request->all());
    	}else{
    		echo "只有get方法才能访问";
    	}
 
    }

    //获取请求数据
    /**
     * @param Request $request
     */
    public function getInputData(Request $request){
        $allData = $request->all();

        $dataOnly = $request->only(['name','age']);

        $dataExpect = $request->except('name');

        echo "<pre>";
        print_r($allData);

        echo '<br>';

        print_r($dataOnly);

        echo '<br>';

        print_r($dataExpect);
    }


    /*
     *上一次请求输入  如果想要获取上一次请求的输入，需要在处理上一次请求时使用Request实例上的flash方法将请求数据暂时保存到session中，
     * 然后在当前请求中使用Request实例上的old方法获取session中保存的数据，获取到数据后就会将session中保存的请求数据销毁
     */
    public function getLastRequest(Request $request){
//        $request->flash();

        return redirect('request/getCurrentRequest')->withInput();
    }

    public function getCurrentRequest(Request $request){
        $latRequestData = $request->old();
        echo '<pre>';
        print_r($latRequestData);
    }


    // 获取Cookie数据
    /*
     * 我们可以使用Request实例上的cookie方法获取cookie数据，该方法可以接收一个参数名返回对应的cookie值，如果不传入参数，默认返回所有cookie值：
     * */
    public function getCookie(Request $request){
        echo '<pre>';
        print_r($_COOKIE);
        $website = $request->cookie('website');
        print $website;
        $cookie = $request->cookie();
        dd($cookie);
    }

    //我们可以调用Response实例上的withCookie方法新增cookie：
    public function getAddCookie(){
        // 要use头文件才可以实例化这个对象
        $respone = new Response();
        // 第一个参数㐊cookie的名字 第二个是cookie的值 第三个是有效期
        $respone->withCookie(cookie('website','ccsec.cn',1));

        return $respone;
    }



    //get Session数据
    public function session1(Request $request){
        // put key => value
        // use Request的命名空间才可以调用session()这个方法
        session()->put('k1','123');
        // 要use命名空间才可以调用这个方法
        Session::put('k2','124');
        $request->session()->put(['k3'=>['k4'=>'125','k5'=>'126']]);
    }

    public function session2(){
        echo "<pre>";
        $data = session()->all();  // 获得session里面的值
        print_r($data);

        echo Session::all()['_token'];
        echo '<br>';
        echo Session::get('_token');
        echo '<br>';
        print session()->get('_token');

    }

    public function session3(){
        //将session里面的数据清除
        session()->flush();
    }

    // 文件上传
    public function getFileupload(){
        $postUrl = url('request/fileupload');
        $csrf_field = csrf_field();
        $html=<<<CREATE
        <form action='$postUrl' method='post' enctype='multipart/form-data'>
            $csrf_field
            <input type='file' name='file' /><br><br>
            <input type='submit' name='sub' value='提交'/>
        </form>
CREATE;
        return $html;
    }

    //文件上传处理
    public  function postFileupload(Request $request){
        // 判断请求中是否包含name=file的上传文件
        if(!$request->hasFile('file')){
            die('上传文件为空');
        }
        $file = $request->file('file');

        //判断上传过程是否出现错误
        if(!$file->isValid()){
            die('文件上传出错！');
        }
        // realpath（）是判断路径是否存在的
        $isexit = realpath(public_path('images'));
        $desPath = public_path('images');
        if(!$isexit){
            mkdir($desPath);
        }

//        $filename =  $file->getClientOriginalName();

        $filename = date('Y-m-d-H-i-s',time()).'.'.$file->getClientOriginalExtension();
        echo $filename;
        if(!$file->move($desPath,$filename)){
            die('保存文件失败');
        }
        $backurl = url('request/getFileupload');
       echo "<script type='text/javascript'>alert('上传成功');window.location.href='$backurl'; </script>";
        //       return redirect()->back();
    }
}