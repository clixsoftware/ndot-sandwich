<div id="api">


	<div class="class">
		<h1 class="signature"><a name="Twitter_user_Model"></a>Twitter_user_Model</h1>
		<div class="overview">
			<h2>Overview</h2>
	
		<p class="description"><em>Twitter User Model</em></p> 
			<p class="info">Used to manage, load and store data about a twitter user</p>
			</div>
	
		<div class="properties">
	
			<h2>Properties</h2>
	
			<table class="properties" callspacing="0" cellpadding="3">
			
				<tr><td class="property"><span class="static"></span> <span class="name">$access_key</span> </td><td class="description"><em>Stores the Users Oauth access key</em></td></tr>
				<tr><td class="property"><span class="static"></span> <span class="name">$secret_key</span> </td><td class="description"><em>Stores the Users Oauth secret key</em></td></tr>
				<tr><td class="property"><span class="static"></span> <span class="name">$username</span> </td><td class="description"><em>Stores the Twitter username</em></td></tr>
				<tr><td class="property"><span class="static"></span> <span class="name">$consumer</span> </td><td class="description"><em>Stores the Oauth consumer for this user</em></td></tr>
				</table>
		</div>
	
		<div class="methods">
	
			<h2>Methods</h2>
			<div class="method">
				<h3 class="signature"><a name="Twitter_user_Model()"></a><span class="static"></span> <span class="name">Twitter_user_Model()</span> </h3>
			<p class="description"><em>Twitter User Model</em></p> 
				<p class="info">Creates a new model instance</p>
				<pre>$twitter_user_model = new Twitter_user_Model();</pre>
			</div>
			
			<div class="method">
				<h3 class="signature"><a name="set_keys($access_key,$secret_key)"></a><span class="static"></span> <span class="name">set_keys($access_key,$secret_key)</span> </h3>
			<p class="description"><em>Set Users Oauth keys</em></p> 
				<p class="info">Assign $access_key and $secret_key as a users keys and generate
			new consumer from them (assigned to $this->consumer). Keys can
			either be Request or Access.</p>
				<pre>$twitter_user_model->set_keys($access_key, $secret_key);</pre>
			</div>
			
			<div class="method">
				<h3 class="signature"><a name="set_username($username)"></a><span class="static"></span> <span class="name">set_username($username)</span> </h3>
			<p class="description"><em>Set Users Twitter username</em></p> 
				<p class="info">Associates a Twitter username with the object instance</p>
				<pre>$twitter_user_model->set_username($username);</pre>
			</div>
			
			<div class="method">
				<h3 class="signature"><a name="set_session($session='twitter_oauth',$encrypt=True)"></a><span class="static"></span> <span class="name">set_session($session='twitter_oauth',$encrypt=True)</span> </h3>
			<p class="description"><em>Saves Oauth keys in a session variable</em></p> 
				<p class="info">Saves the users assigned Oauth keys. During stage one
			of the key transfer this will be the request keys the
			session variable used can be changed to reflect this,.</p>
				<pre>$twitter_user_model->set_session($session, $encrypt);</pre>
			</div>
			
			<div class="method">
				<h3 class="signature"><a name="store_keys()"></a><span class="static"></span> <span class="name">store_keys()</span> </h3>
			<p class="description"><em>Store Oauth Keys</em></p> 
				<p class="info">Store the users Oauth access keys in the database along with
			their username for later retrieval</p>
				<pre>$twitter_user_model->store_keys();</pre>
			</div>
			
			<div class="method">
				<h3 class="signature"><a name="delete_keys()"></a><span class="static"></span> <span class="name">delete_keys()</span> </h3>
			<p class="description"><em>Delete users Oauth keys</em></p> 
				<p class="info">Delete the stored keys from the database if they exist</p>
				<pre>$twitter_user_model->delete_keys();</pre>
			</div>
			
			<div class="method">
				<h3 class="signature"><a name="get_from_cookie($cookie_string)"></a><span class="static">static</span> <span class="name">get_from_cookie($cookie_string)</span> </h3>
			<p class="description"><em>Retrieve user information from the cookie</em></p> 
				<p class="info">Takes the data from the stored cookie and figures out the user
			from it, then obtains the correct keys from the DB.</p>
				<pre>Twitter_user_Model::get_from_cookie($cookie_string);</pre>
			</div>
			
			<div class="method">
				<h3 class="signature"><a name="get_from_session($session_tokens)"></a><span class="static">static</span> <span class="name">get_from_session($session_tokens)</span> </h3>
			<p class="description"><em>Obtain user information from session</em></p> 
				<p class="info">Queries the session variables for information about the
			current logged in user. Queries the DB to verify info.</p>
				<pre>Twitter_user_Model::get_from_session($session_tokens);</pre>
			</div>
			
			<div class="method">
				<h3 class="signature"><a name="retrieve_user_from_db($username,$tokens_hash)"></a><span class="static">static</span> <span class="name">retrieve_user_from_db($username,$tokens_hash)</span> </h3>
			<p class="description"><em>Retrieve a users keys from the DB</em></p> 
				<p class="info">Retrieves a users details from the DB and verifies either
			encrypted cookie or session data to verify the user is valid</p>
				<pre>Twitter_user_Model::retrieve_user_from_db($username, $tokens_hash);</pre>
			</div>
		</div>
	</div>
	
	

</div>

