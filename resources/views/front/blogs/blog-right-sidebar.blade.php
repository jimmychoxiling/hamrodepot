<div class="col col-3">
    <div class="card">
        <div class="blog_sildebar">
            <div class="blog_sb_step">
                <form action="{{ route('blogs') }}" method="get" data-parsley-validate="">
                <div class="blog_sb_input_wrap">
                    <i class="fa fa-search"></i>
                    <input type="search" class="form-control" placeholder="Search..." name="s" value="{{Request::get('s')}}" required>
                </div>
                </form>
            </div>
            <div class="blog_sb_step">
                <div class="blog_sb_title">
                    <h3>Recent DIYs</h3>
                </div>
                <div class="blog_sb_post_list">
                    <ul>
                        @foreach($recent_blogs as $recent_blog)
                        <li class="blog_sb_post_item">
                            <a href="{{ route('blog-detail', array('slug2' => $recent_blog->slug)) }}">{{ $recent_blog->name }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="blog_sb_step">
                <div class="blog_sb_title">
                    <h3>Categories</h3>
                </div>
                <div class="blog_sb_category_list">
                    <ul>
                        @foreach($blog_categories as $blog_category)
                        <li class="blog_sb_category_item"><a href="{{ route('blogs', array('slug2' => $blog_category->slug)) }}">{{ $blog_category->name }} ({{ $blog_category->blogsCount() }})</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="blog_sb_step">
                <div class="blog_sb_title">
                    <h3>Archives</h3>
                </div>
                <div class="blog_sb_archive">
                    <select name="archivesblog" id="archivesblog" class="form-control">
                        <option selected="" disabled="">Select Month</option>
                        @foreach($archives_month_list as $archives_month_list_val)
                           <?php
                                $dateObj   = DateTime::createFromFormat('!m', $archives_month_list_val->month);
                                $monthName = $dateObj->format('F');
                            ?>
                        <option value="{{ route('blogs', array('slug2' => $archives_month_list_val->year, 'slug3' => $archives_month_list_val->month)) }} ">{{ $monthName }} {{$archives_month_list_val->year}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
