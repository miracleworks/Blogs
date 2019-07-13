<!DOCTYPE html>
<html>
<head>
<title>
    {% if is_login %}Login
    {% elif is_home or is_blog %}{{ site.author }}
    {% elif is_tag %}Posts tagged "{{ tag|format_tag(False, True) }}"
    {% elif post %}{{ post.title }}
    {% endif %}
    | {{ site.name }}
  </title>
{{ header_meta }}
<link rel="stylesheet" type="text/css" href="{{ assets('css/normalize.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ assets('css/nprogress.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ assets('css/style.css') }}" />
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin,cyrillic-ext,latin-ext,cyrillic" />
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
<style>
    .site-bio {
      width: 70%;
      margin: 0 auto;
      text-align: center;
      line-height: 1.5em;
    }
    .site-bio a,
    .site-bio a:link,
    .site-bio a:visited {
      text-decoration: underline;
    }
    .site-avatar {
      width: 120px;
      height: 120px;
      border-radius: 60px;
      -webkit-border-radius: 60px;
      -moz-border-radius: 60px;
      background-image: url({{ site.avatar }});
      background-size: 120px 120px;
      background-repeat: no-repeat;
    }
    .post-content img {
      width: 100%;
    }
  </style>
</head>
<body class="home-template">
{% if is_login %}
{{ login_form }}
{% else %}
<div id="wrapper">
<header class="site-header">
<div class="container">
<div class="site-title-wrapper">
<a class="site-logo js-ajax-link" title="{{ site.name }}" href="{{ site.base_url }}">
<div class="site-avatar"></div>
</a>
</div>
<ul class="site-nav">
<li class="site-nav-item"><a class="js-ajax-link js-show-index" title="Home" href="{{ site.base_url }}">Home</a></li>
{% if homepage %}
<li class="site-nav-item"><a href="/blog">Blog</a></li>
{% endif %}
{% if site.twitter %}
<li class="site-nav-item"><a class="js-ajax-link" title="Twitter" href="{{ site.twitter }}" target="_blank">Twitter</a></li>
{% endif %}
{% if site.facebook %}
<li class="site-nav-item"><a class="js-ajax-link" title="Facebook" href="{{ site.facebook }}" target="_blank">Facebook</a></li>
{% endif %}
{% if site.instagram %}
<li class="site-nav-item"><a class="js-ajax-link" title="Instagram" href="{{ site.instagram }}" target="_blank">Instagram</a></li>
{% endif %}
{% if site.googleplus %}
<li class="site-nav-item"><a class="js-ajax-link" title="Google+" href="{{ site.googleplus }}" target="_blank">Google+</a></li>
{% endif %}
{% if site.linkedin %}
<li class="site-nav-item"><a class="js-ajax-link" title="LinkedIn" href="{{ site.linkedin }}" target="_blank">LinkedIn</a></li>
{% endif %}
{% for page in pages %}
<li class="site-nav-item">
<a class="js-ajax-link" title="{{ page.title }}" href="{{ page.permalink }}">
{{ page.title }}
</a>
</li>
{% endfor %}
<li class="site-nav-item"><a href="{{ site.atom_url }}">RSS</a></li>
</ul>
</div>
</header>
<div id="ajax-container">
<div class="container">
{% if is_home and homepage %}
<article class="post-container post">
<header class="post-header">
<h1 class="post-title">{{ homepage.title }}</h1>
</header>
<div class="post-content clearfix">
{{ homepage.content }}
</div>
</article>
{% elif is_home or is_blog or is_tag %}
<h1 class="page-title">
{% if is_tag %}
Posts tagged "{{ tag|format_tag(False, True) }}"
{% else %}
{{ site.name }}
{% endif %}
</h1>
{% if is_home and site.bio %}
<p class="blog-description site-bio">{{ site.bio }}</p>
{% endif %}
<ol class="post-list">
{% if not posts %}
<li class="post-stub post"><em>Hmm, no posts. So lonely...</em></li>
{% else %}
{% for post in posts %}
<li class="post-stub post">
<a class="js-ajax-link" title="{{ post.title }}" href="{{ post.url }}">
<h4 class="post-stub-title">{{ post.title|truncate(50) }}</h4>
<time class="post-stub-date" datetime="{{ post.created_at|format_date }}">
Published {{ post.created_at|format_date }}
</time>
</a>
</li>
{% endfor %}
{% endif %}
</ol>
<div class="post-navigation">
{% if pagination.prev or pagination.next %}
<nav class="pagination" role="navigation">
{% if pagination.prev %}
<a class="newer-posts" href="{{ pagination.prev }}">&larr; Newer Posts</a>
{% endif %}
{% if pagination.next %}
<a class="older-posts" href="{{ pagination.next }}">Older Posts &rarr;</a>
{% endif %}
</nav>
{% endif %}
</div>
{% elif is_post or is_link or is_page %}
<article class="post-container post">
<header class="post-header">
<h1 class="post-title">{{ post.title }}</h1>
{% if is_post or is_link %}
<p class="post-date">
Published <time datetime="{{ post.created_at|format_date }}">{{ post.created_at|format_date }}</time>
<strong>by {{ site.author }}</strong>
</p>
{% endif %}
</header>
<div class="post-content clearfix">
{{ post.content }}
{% if is_link %}
<p>Source: <a href="{{ post.link_url }}" target="_blank">{{ post.link_url|truncate_url }}</a></p>
{% endif %}
</div>
{% if is_post or is_link %}
<footer class="post-footer clearfix">
{% if post.tags %}
<p class="post-tags"><span>Tagged:</span> {{ post.tags|format_tags }}</p>
{% endif %}
<div class="share">
<a class="icon-twitter" href="https://twitter.com/share?text={{ post.title }}&url={{ post.permalink }}" onclick="window.open(this.href, 'twitter-share', 'width=550,height=235');return false;">
<i class="fa fa-twitter"></i>
<span class="hidden">Twitter</span>
</a>
<a class="icon-facebook" href="https://www.facebook.com/sharer/sharer.php?u={{ post.permalink }}" onclick="window.open(this.href, 'facebook-share','width=580,height=296');return false;">
<i class="fa fa-facebook"></i>
<span class="hidden">Facebook</span>
</a>
<a class="icon-google-plus" href="https://plus.google.com/share?url={{ post.permalink }}" onclick="window.open(this.href, 'google-plus-share', 'width=490,height=530');return false;">
<i class="fa fa-google-plus"></i>
<span class="hidden">Google+</span>
</a>
</div>
</footer>
{% if site.disqus %}
<section class="comments">
<hr class="large" />
<div id="disqus_thread"></div>
<script type="text/javascript">
                var disqus_shortname = '{{ site.disqus }}';
                var disqus_url = '{{site.base_url}}{{ post.url }}';
                (function() {
                  var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                  dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                  (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                })();
                </script>
<noscript>
                  Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a>
                </noscript>
<a href="https://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
</section>
{% endif %}
{% endif %}
</article>
{% endif %}
</div>
</div>
</div>
<footer class="footer">
<div class="container">
<div class="site-title-wrapper">
<h1 class="site-title">
<a class="js-ajax-link" title="{{ site.name }}" href="{{ site.base_url }}">
{{ site.name }}
</a>
</h1>
<a class="button-square button-jump-top js-jump-top" href="#"><i class="fa fa-angle-up"></i></a>
</div>
<p class="footer-copyright">
Powered by <a href="http://postach.io">Postach.io</a> /
<a href="https://github.com/roryg/ghostwriter">Ghostwriter</a> theme /
<a href="{{ site.atom_url }}">RSS</a>
</p>
</div>
</footer>
{% endif %}
<script type="text/javascript" src="{{ assets('js/jquery.history.js') }}"></script>
<script type="text/javascript" src="{{ assets('js/nprogress.js') }}"></script>
<script type="text/javascript" src="{{ assets('js/jquery.fitvids.js') }}"></script>
{% if site.analytics %}
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '{{ site.analytics }}']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = 'https://ssl.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
  </script>
{% endif %}
</body>
</html>