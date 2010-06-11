Installation is reasonably simple.
<h2>Get an API Key</h2>
The first step is to <?=html::anchor('http://www.twitter.com/oauth_clients','register a Twitter app');?> to obtain your consumer keys.
<br />
<br />This is free and instant so go ahead and do that now. You will need to provide a Callback URL - this is where Twitter sends the user after then authorise the Oauth login. 
For the demo to work you must set it to <i>yoursite.com/ktwitter/demo/completed</i> (obviously in your production code you will have your own callback url)
<h2>Copy files / SQL</h2>
Copy KTwitter to your web server. It can be copied as either a Module or directly into your application folder (I recommend for former!)
<br />
<br />You also need to set up a table in your sites default database (note: currently Ktwitter only uses your default database, hopefully that is on the agenda to be fixed)
You can use the following SQL code to get the right setup (choose a more approriate table name if you wish)
<br />
<br />
<div class="sql" >
    <!-- Parsed with Geshi Syntax higlighter -->
            <ol><li class="li1"><div class="de1"><span class="kw1">CREATE</span> <span class="kw1">TABLE</span> &nbsp;<span class="st0">`twitter_users`</span> <span class="br0">&#40;</span></div></li>
            <li class="li1"><div class="de1"><span class="st0">`user`</span> VARCHAR<span class="br0">&#40;</span> <span class="nu0">50</span> <span class="br0">&#41;</span> <span class="kw1">NOT</span> <span class="kw1">NULL</span> <span class="sy0">,</span></div></li>

            <li class="li1"><div class="de1"><span class="st0">`access_key`</span> TEXT <span class="kw1">NOT</span> <span class="kw1">NULL</span> <span class="sy0">,</span></div></li>
            <li class="li1"><div class="de1"><span class="st0">`secret_key`</span> TEXT <span class="kw1">NOT</span> <span class="kw1">NULL</span> <span class="sy0">,</span></div></li>

            <li class="li1"><div class="de1"><span class="kw1">PRIMARY</span> <span class="kw1">KEY</span> <span class="br0">&#40;</span> &nbsp;<span class="st0">`user`</span> <span class="br0">&#41;</span></div></li>
            <li class="li1"><div class="de1"><span class="br0">&#41;</span></div></li>
            <li class="li1"><div class="de1">&nbsp;</div></li>
</div>
<h2>Configuration</h2>
Next step is to locate your config/ktwitter.php file and open it up. This is crucial because you have to enter your consumer keys for KTwitter to work!
<h3>consumer_key & consumer_secret</h3>
These are the Oauth keys provided by twitter, you need to enter them in full.
<h3>database_table</h3>
Enter the name of the table you created for storing KTwitter data. If you cut and pasted the above SQL snippet then the default will be correct.
<h3>use_kcurl_library</h3>
Ignore this for now. KTwitter uses CURL to get data - at one point I meant to provide integration with <?=html::anchor('http://dev.kohanaphp.com/projects/curl','Sam Clarks CURL module');?>. 
That might still happen in the future.
<h3>cookie</h3>
KTwitter uses a cookie to track the Oauth session (yes, this might well be expanded in the future - it's early days :)). 
The syntax is identical to the <?=html::anchor('http://docs.kohanaphp.com/helpers/cookie','Kohana Cookie configuration');?> (as it uses the cookie helper to operate)
<h2>GO!</h2>
Surf to <?=html::anchor('ktwitter/examples','the examples page');?> to check everything works correctly. Then stop by the <?=html::anchor('ktwitter/api','API documentation');?> to kick start your coding.
<br />
<br />
<br />
<br />