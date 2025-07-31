<?php /* Template Name: Search */ ?>
<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package cuhk_chi
 */

get_header();

// Include roll menu
get_template_part('template-parts/roll-menu');

if (have_posts()) :
	while (have_posts()) : the_post();
?>

		<div class="section section_content " x-data='search_list' x-init="init">
			<img src="<?php echo get_template_directory_uri(); ?>/images/ink_bg9.jpg" class="ink_bg9 scrollin scrollinbottom" alt="Background">
			<div class="section_center_content small_section_center_content">
                <h1 class="section_title text1 scrollin scrollinbottom"><?php echo cuhk_multilang_text("搜尋", "", "Search"); ?></h1>
            
                <div class="section_description scrollin scrollinbottom col6">
                    <div class="text6 keyword_title"><?php echo cuhk_multilang_text("關鍵字", "", "Keyword"); ?>: </div>
                    <div class="search_wrapper">
                        <input type="text" placeholder="<?php echo cuhk_multilang_text("我想尋找...", "", "I am looking for..."); ?>" id="search_result_input" class="search_input" x-model="filter.keyword" @keyup.enter="query"/> 
                        <div @click="query" class="submit_arrow"></div>
                    </div>
                </div>
			</div>

            <div class="search_section">
                <div class="section_center_content small_section_center_content">
                    <!-- other "spotlights" goes here--> 
                    <div class="search_row_wrapper scrollin_p">
                        <div class="col_wrapper big_col_wrapper">
                            <div class="row flex" x-show="result.length>0">
                                <template x-for="(elm,index) in result">
                                    <div class="col col6">
                                        <div class="col_spacing">
                                            <div class="top_wrapper">
                                                <div class="subtitle text9" x-show="elm.parent_title"><span x-html="elm.parent_title" ></span></div>
                                                <div class="subtitle text9" x-show="elm.type"><span x-html="elm.type" ></span></div>
                                                <div class="title text6">
                                                    <span x-html="elm.title">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="btn_wrapper">
                                                <ul>
                                                    <li><a x-bind:href="elm.link" class="line_btn"><span><?php echo cuhk_multilang_text("閱讀更多", "", "View More"); ?></span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                            <div x-show="done && result.length==0" style="text-align:center"><?php echo cuhk_multilang_text("找不到任何結果", "", "Sorry, please search again."); ?></div>

                            <div x-show="!done && result.length==0" style="text-align:center"><?php echo cuhk_multilang_text("載入中...", "", "Loading..."); ?></div>
                        </div>
                    </div>

                

                    <div class="search_pagination" x-show="pager.total>1">

                        <div class='wp-pagenavi' role='navigation'>
                            <a class="previouspostslink" rel="prev" @click="prev()" href="javascript:void(0);" x-show="pager.current>1"><?php echo cuhk_multilang_text("上一頁", "", "PREV"); ?></a>
                            <template x-for="(elm,index) in new Array(pager.total)">
                                <span>
                                    <span class='current' x-show="pager.current==index+1" x-text="index+1"></span>
                                    <a class="page larger"  @click="goto(index+1)" href="javascript:void(0);" x-show="pager.current!=(index+1)" x-text="index+1"></a>
                                </span>
                            </template>
                            <a class="nextpostslink" rel="next" @click="next()" href="javascript:void(0);" x-show="pager.current<(pager.total)"><?php echo cuhk_multilang_text("下一頁", "", "NEXT"); ?></a>
                            
                        </div>

                    </div>
                </div>
            </div>
		</div>

<?php
	endwhile;
endif;
?>
<script>
  document.addEventListener("alpine:init", () => {
    Alpine.data("search_list", () => ({
        "pager":{
            current:1,
            total:1
        },
        "done":false,
        "filter": {
            "keyword":null,
        },
        "result": [],
        prev: function(){
            var prev = parseInt(this.pager.current)-1;

            this.goto(prev>0? prev:1);

        },
        next: function(){

            var next = parseInt(this.pager.current)+1;

            this.goto(next>this.pager.total? this.pager.total:next);

        },
        goto: function(page) {

            this.pager.current = page;

            this.query();

        },
        buildQ : function(params){
            const url = new URL(window.location.href);
            Object.keys(params).forEach(function(key){
                if( params[key])
                url.searchParams.set(key, params[key]);
                else 
                url.searchParams.delete(key);
            });
            history.pushState(null, document.title, url.toString());

        },
        init:function(){

            this.filter.keyword = new URLSearchParams(location.search).get('keyword') || null;
            this.pager.current = new URLSearchParams(location.search).get('pager') || 1;

            this.query();

            
        },
        query:function(){

            const filter_dropdown_close = this.$refs.filter_dropdown_close;

            var that = this;

            var params = {
                keyword: that.filter.keyword,
                pager: that.pager.current
            };

            this.buildQ(params);

            params['action'] = "get_search";
            params['filter'] = that.prefilter;

            jQuery(".news_loading").stop().fadeIn(300);

            jQuery.ajax({
                    type : "post",
                    dataType : "json",
                    url : '<?php echo  admin_url( 'admin-ajax.php' )?>',
                    data : params,
                    success: function(response) {
                        if(response.type == "success") {
                             that.result = response.data;
                             that.pager.total = response.total;


                             //filter_dropdown_close.click();
                        }

                        that.done = true;
                        jQuery(".news_loading").stop().fadeOut(300);
                    }
                })   

        
        }
    }))});
</script>
<?php
get_footer();
