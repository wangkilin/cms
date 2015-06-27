<?php
array (
  0 => 
  array (
    'index' => 
    array (
      'url' => '/',
      'widget' => 'Widget_Archive',
      'action' => 'render',
      'regx' => '|^[/]?$|',
      'format' => '/',
      'params' => 
      array (
      ),
    ),
    'archive' => 
    array (
      'url' => '/blog/',
      'widget' => 'Widget_Archive',
      'action' => 'render',
      'regx' => '|^/blog[/]?$|',
      'format' => '/blog/',
      'params' => 
      array (
      ),
    ),
    'do' => 
    array (
      'url' => '/action/[action:alpha]',
      'widget' => 'Widget_Do',
      'action' => 'action',
      'regx' => '|^/action/([_0-9a-zA-Z-]+)[/]?$|',
      'format' => '/action/%s',
      'params' => 
      array (
        0 => 'action',
      ),
    ),
    'post' => 
    array (
      'url' => '/archives/[cid:digital]/',
      'widget' => 'Widget_Archive',
      'action' => 'render',
      'regx' => '|^/archives/([0-9]+)[/]?$|',
      'format' => '/archives/%s/',
      'params' => 
      array (
        0 => 'cid',
      ),
    ),
    'attachment' => 
    array (
      'url' => '/attachment/[cid:digital]/',
      'widget' => 'Widget_Archive',
      'action' => 'render',
      'regx' => '|^/attachment/([0-9]+)[/]?$|',
      'format' => '/attachment/%s/',
      'params' => 
      array (
        0 => 'cid',
      ),
    ),
    'category' => 
    array (
      'url' => '/category/[slug]/',
      'widget' => 'Widget_Archive',
      'action' => 'render',
      'regx' => '|^/category/([^/]+)[/]?$|',
      'format' => '/category/%s/',
      'params' => 
      array (
        0 => 'slug',
      ),
    ),
    'tag' => 
    array (
      'url' => '/tag/[slug]/',
      'widget' => 'Widget_Archive',
      'action' => 'render',
      'regx' => '|^/tag/([^/]+)[/]?$|',
      'format' => '/tag/%s/',
      'params' => 
      array (
        0 => 'slug',
      ),
    ),
    'author' => 
    array (
      'url' => '/author/[uid:digital]/',
      'widget' => 'Widget_Archive',
      'action' => 'render',
      'regx' => '|^/author/([0-9]+)[/]?$|',
      'format' => '/author/%s/',
      'params' => 
      array (
        0 => 'uid',
      ),
    ),
    'search' => 
    array (
      'url' => '/search/[keywords]/',
      'widget' => 'Widget_Archive',
      'action' => 'render',
      'regx' => '|^/search/([^/]+)[/]?$|',
      'format' => '/search/%s/',
      'params' => 
      array (
        0 => 'keywords',
      ),
    ),
    'index_page' => 
    array (
      'url' => '/page/[page:digital]/',
      'widget' => 'Widget_Archive',
      'action' => 'render',
      'regx' => '|^/page/([0-9]+)[/]?$|',
      'format' => '/page/%s/',
      'params' => 
      array (
        0 => 'page',
      ),
    ),
    'archive_page' => 
    array (
      'url' => '/blog/page/[page:digital]/',
      'widget' => 'Widget_Archive',
      'action' => 'render',
      'regx' => '|^/blog/page/([0-9]+)[/]?$|',
      'format' => '/blog/page/%s/',
      'params' => 
      array (
        0 => 'page',
      ),
    ),
    'category_page' => 
    array (
      'url' => '/category/[slug]/[page:digital]/',
      'widget' => 'Widget_Archive',
      'action' => 'render',
      'regx' => '|^/category/([^/]+)/([0-9]+)[/]?$|',
      'format' => '/category/%s/%s/',
      'params' => 
      array (
        0 => 'slug',
        1 => 'page',
      ),
    ),
    'tag_page' => 
    array (
      'url' => '/tag/[slug]/[page:digital]/',
      'widget' => 'Widget_Archive',
      'action' => 'render',
      'regx' => '|^/tag/([^/]+)/([0-9]+)[/]?$|',
      'format' => '/tag/%s/%s/',
      'params' => 
      array (
        0 => 'slug',
        1 => 'page',
      ),
    ),
    'author_page' => 
    array (
      'url' => '/author/[uid:digital]/[page:digital]/',
      'widget' => 'Widget_Archive',
      'action' => 'render',
      'regx' => '|^/author/([0-9]+)/([0-9]+)[/]?$|',
      'format' => '/author/%s/%s/',
      'params' => 
      array (
        0 => 'uid',
        1 => 'page',
      ),
    ),
    'search_page' => 
    array (
      'url' => '/search/[keywords]/[page:digital]/',
      'widget' => 'Widget_Archive',
      'action' => 'render',
      'regx' => '|^/search/([^/]+)/([0-9]+)[/]?$|',
      'format' => '/search/%s/%s/',
      'params' => 
      array (
        0 => 'keywords',
        1 => 'page',
      ),
    ),
    'archive_year' => 
    array (
      'url' => '/[year:digital:4]/',
      'widget' => 'Widget_Archive',
      'action' => 'render',
      'regx' => '|^/([0-9]{4})[/]?$|',
      'format' => '/%s/',
      'params' => 
      array (
        0 => 'year',
      ),
    ),
    'archive_month' => 
    array (
      'url' => '/[year:digital:4]/[month:digital:2]/',
      'widget' => 'Widget_Archive',
      'action' => 'render',
      'regx' => '|^/([0-9]{4})/([0-9]{2})[/]?$|',
      'format' => '/%s/%s/',
      'params' => 
      array (
        0 => 'year',
        1 => 'month',
      ),
    ),
    'archive_day' => 
    array (
      'url' => '/[year:digital:4]/[month:digital:2]/[day:digital:2]/',
      'widget' => 'Widget_Archive',
      'action' => 'render',
      'regx' => '|^/([0-9]{4})/([0-9]{2})/([0-9]{2})[/]?$|',
      'format' => '/%s/%s/%s/',
      'params' => 
      array (
        0 => 'year',
        1 => 'month',
        2 => 'day',
      ),
    ),
    'archive_year_page' => 
    array (
      'url' => '/[year:digital:4]/page/[page:digital]/',
      'widget' => 'Widget_Archive',
      'action' => 'render',
      'regx' => '|^/([0-9]{4})/page/([0-9]+)[/]?$|',
      'format' => '/%s/page/%s/',
      'params' => 
      array (
        0 => 'year',
        1 => 'page',
      ),
    ),
    'archive_month_page' => 
    array (
      'url' => '/[year:digital:4]/[month:digital:2]/page/[page:digital]/',
      'widget' => 'Widget_Archive',
      'action' => 'render',
      'regx' => '|^/([0-9]{4})/([0-9]{2})/page/([0-9]+)[/]?$|',
      'format' => '/%s/%s/page/%s/',
      'params' => 
      array (
        0 => 'year',
        1 => 'month',
        2 => 'page',
      ),
    ),
    'archive_day_page' => 
    array (
      'url' => '/[year:digital:4]/[month:digital:2]/[day:digital:2]/page/[page:digital]/',
      'widget' => 'Widget_Archive',
      'action' => 'render',
      'regx' => '|^/([0-9]{4})/([0-9]{2})/([0-9]{2})/page/([0-9]+)[/]?$|',
      'format' => '/%s/%s/%s/page/%s/',
      'params' => 
      array (
        0 => 'year',
        1 => 'month',
        2 => 'day',
        3 => 'page',
      ),
    ),
    'comment_page' => 
    array (
      'url' => '[permalink:string]/comment-page-[commentPage:digital]',
      'widget' => 'Widget_Archive',
      'action' => 'render',
      'regx' => '|^(.+)/comment\\-page\\-([0-9]+)[/]?$|',
      'format' => '%s/comment-page-%s',
      'params' => 
      array (
        0 => 'permalink',
        1 => 'commentPage',
      ),
    ),
    'feed' => 
    array (
      'url' => '/feed[feed:string:0]',
      'widget' => 'Widget_Archive',
      'action' => 'feed',
      'regx' => '|^/feed(.*)[/]?$|',
      'format' => '/feed%s',
      'params' => 
      array (
        0 => 'feed',
      ),
    ),
    'feedback' => 
    array (
      'url' => '[permalink:string]/[type:alpha]',
      'widget' => 'Widget_Feedback',
      'action' => 'action',
      'regx' => '|^(.+)/([_0-9a-zA-Z-]+)[/]?$|',
      'format' => '%s/%s',
      'params' => 
      array (
        0 => 'permalink',
        1 => 'type',
      ),
    ),
    'page' => 
    array (
      'url' => '/[slug].html',
      'widget' => 'Widget_Archive',
      'action' => 'render',
      'regx' => '|^/([^/]+)\\.html[/]?$|',
      'format' => '/%s.html',
      'params' => 
      array (
        0 => 'slug',
      ),
    ),
  ),
  'index' => 
  array (
    'url' => '/',
    'widget' => 'Widget_Archive',
    'action' => 'render',
  ),
  'archive' => 
  array (
    'url' => '/blog/',
    'widget' => 'Widget_Archive',
    'action' => 'render',
  ),
  'do' => 
  array (
    'url' => '/action/[action:alpha]',
    'widget' => 'Widget_Do',
    'action' => 'action',
  ),
  'post' => 
  array (
    'url' => '/archives/[cid:digital]/',
    'widget' => 'Widget_Archive',
    'action' => 'render',
  ),
  'attachment' => 
  array (
    'url' => '/attachment/[cid:digital]/',
    'widget' => 'Widget_Archive',
    'action' => 'render',
  ),
  'category' => 
  array (
    'url' => '/category/[slug]/',
    'widget' => 'Widget_Archive',
    'action' => 'render',
  ),
  'tag' => 
  array (
    'url' => '/tag/[slug]/',
    'widget' => 'Widget_Archive',
    'action' => 'render',
  ),
  'author' => 
  array (
    'url' => '/author/[uid:digital]/',
    'widget' => 'Widget_Archive',
    'action' => 'render',
  ),
  'search' => 
  array (
    'url' => '/search/[keywords]/',
    'widget' => 'Widget_Archive',
    'action' => 'render',
  ),
  'index_page' => 
  array (
    'url' => '/page/[page:digital]/',
    'widget' => 'Widget_Archive',
    'action' => 'render',
  ),
  'archive_page' => 
  array (
    'url' => '/blog/page/[page:digital]/',
    'widget' => 'Widget_Archive',
    'action' => 'render',
  ),
  'category_page' => 
  array (
    'url' => '/category/[slug]/[page:digital]/',
    'widget' => 'Widget_Archive',
    'action' => 'render',
  ),
  'tag_page' => 
  array (
    'url' => '/tag/[slug]/[page:digital]/',
    'widget' => 'Widget_Archive',
    'action' => 'render',
  ),
  'author_page' => 
  array (
    'url' => '/author/[uid:digital]/[page:digital]/',
    'widget' => 'Widget_Archive',
    'action' => 'render',
  ),
  'search_page' => 
  array (
    'url' => '/search/[keywords]/[page:digital]/',
    'widget' => 'Widget_Archive',
    'action' => 'render',
  ),
  'archive_year' => 
  array (
    'url' => '/[year:digital:4]/',
    'widget' => 'Widget_Archive',
    'action' => 'render',
  ),
  'archive_month' => 
  array (
    'url' => '/[year:digital:4]/[month:digital:2]/',
    'widget' => 'Widget_Archive',
    'action' => 'render',
  ),
  'archive_day' => 
  array (
    'url' => '/[year:digital:4]/[month:digital:2]/[day:digital:2]/',
    'widget' => 'Widget_Archive',
    'action' => 'render',
  ),
  'archive_year_page' => 
  array (
    'url' => '/[year:digital:4]/page/[page:digital]/',
    'widget' => 'Widget_Archive',
    'action' => 'render',
  ),
  'archive_month_page' => 
  array (
    'url' => '/[year:digital:4]/[month:digital:2]/page/[page:digital]/',
    'widget' => 'Widget_Archive',
    'action' => 'render',
  ),
  'archive_day_page' => 
  array (
    'url' => '/[year:digital:4]/[month:digital:2]/[day:digital:2]/page/[page:digital]/',
    'widget' => 'Widget_Archive',
    'action' => 'render',
  ),
  'comment_page' => 
  array (
    'url' => '[permalink:string]/comment-page-[commentPage:digital]',
    'widget' => 'Widget_Archive',
    'action' => 'render',
  ),
  'feed' => 
  array (
    'url' => '/feed[feed:string:0]',
    'widget' => 'Widget_Archive',
    'action' => 'feed',
  ),
  'feedback' => 
  array (
    'url' => '[permalink:string]/[type:alpha]',
    'widget' => 'Widget_Feedback',
    'action' => 'action',
  ),
  'page' => 
  array (
    'url' => '/[slug].html',
    'widget' => 'Widget_Archive',
    'action' => 'render',
  ),
)
/* EOF */