<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Support\Str;

class TestController extends Controller
{
    public function test()
    {

        for ($i = 0; $i < 40; $i++) {
            $a = new Article();
            $a->title = Str::random(20);
            $a->subtitle = Str::random(40);
            $a->thumbnail = "https://pic3.zhimg.com/v2-3be05963f5f3753a8cb75b6692154d4a_1440w.jpg?source=172ae18b";
            $a->content = <<<"EOT"
            `<div class="main-content w1240">
            <!-- 面包削 search start -->
        <!--cID=187315, colID=51922, subCID=51922, thirdCID=third_cid, final=51922 BoYan -->	<div class="path-search" data-sudaclick="cnav_breadcrumbs_p">
            <div class="path">
                            <h1 class="channel-logo"><a data-sudaclick="cnav_logo_news_p" href="https://news.sina.com.cn/" target="_blank"><span>新闻中心</span></a></h1>
                           
                <div class="channel-path"  data-sudaclick="cnav_breadcrumbs_p">
                    
                    <!--
                    <a href="">新浪新闻</a><span class="spliter">></span>
                    -->
                    <a href="http://news.sina.com.cn/china/"> 国内新闻</a><span class="spliter">></span><span>正文</span>            </div>
            </div>
            <div class="search ent-search" id='ent_search' data-sudaclick="cnav_search_p"  style="">
                <form action="//search.sina.com.cn/" name="cheadSearchForm" id="all_search" method="get"
                      target="_blank" style="position: relative;">
                    <select name="c" id="search_type" style="visibility: hidden;">
                        <option value="news">新闻</option>
                        <option value="img">图片</option>
                        <option value="video">视频</option>
                    </select>
                    <input type="hidden" name="ie" value="utf-8">
                    <div class="search_div">
                        <input type="text" id="search_input" name="q" value="请输入关键词" onfocus="if(this.value == '请输入关键词') this.value = ''" onblur="if(this.value =='') this.value = '请输入关键词'" autocomplete="off"><input type="submit" id="search_submit" value="">
                    </div>
                </form>
            </div>
        </div>`;
        EOT;
            $a->author = 1;
            $a->status = 1;
            $a->type = rand(1, 4);
            $a->view = rand(1, 999);
            $a->like = rand(1, 999);
            $a->sort = rand(1, 99);
            $a->save();
        }
    }
}
