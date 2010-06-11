KTwitter is an Twitter library for Kohana based on the new Oauth login procedure. I know there is already a great twitter library but this uses the old username/password method.
Twitter now prefers you to use Oauth - and I think that's a good idea from a security perspective.
<br />
<br />I built this library so that I could use Twitter as a login provider for a site I was developing - any extra functionality is incidental! 
Currently there is only basic Twitter interaction beyond Oauth validation (get status updates, set a new update). 
That said there are meta methods in the library class that will help you make use of the rest of the <a href="http://apiwiki.twitter.com" >Twitter REST api<a/>. 
<br />
<br />KTwitter is open source under the BSD license so you are free to use it as you wish.
<br />
<br />Getting Started:
<ul>
    <li><?php echo html::anchor('http://www.errant.me.uk/ktwitter/demo','Online Demo (hosted on errant.me.uk)');?></a></li>
    <li><?=html::anchor('ktwitter/demo','Examples');?></a></li>
    <li><?=html::anchor('ktwitter/install','First Use & Installation');?></a></li>
    <li><?=html::anchor('ktwitter/api','Api Docs');?> (work in progress, use <?=html::anchor('http://bitbucket.org/errant/ktwitter/src/tip/libraries/Twitter.php','the source code');?> for now)</li>
    <li><?=html::anchor('http://hg.errant.me.uk/errant/ktwitter/issues','Report any bugs');?></li>
</ul>
<br />
<br />
By the way the "logo" is am image by <?=html::anchor('http://www.iampaddy.com','Paddy Donnelly');?> (<?=html::anchor('http://blog.iampaddy.com/2008/11/04/twitterigami/','here is the source');?>). 
It's an open source image but he gave permission too :)