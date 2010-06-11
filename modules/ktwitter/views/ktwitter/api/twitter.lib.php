<div id="api">


	<div class="class">
		<h1 class="signature"><a name="Twitter"></a>Twitter</h1>
		<div class="overview">
			<h2>Overview</h2>
	
		<p class="description"><em>Twitter Oauth Class</em></p> 
			<p class="info">Provides interfaces for executing an Oath exchange and
		retrieving a users key/secret. Also includes some
		basic API examples and helper code for constructing
		Twitter API requests</p>
			</div>
	
		<div class="properties">
	
			<h2>Properties</h2>
	
			<table class="properties" callspacing="0" cellpadding="3">
			
				<tr><td class="property"><span class="static"></span> <span class="name">$user</span> </td><td class="description"><em>Stores the logged in Twitter_user_Model</em></td></tr>
				</table>
		</div>
	
		<div class="methods">
	
			<h2>Methods</h2>
			<div class="method">
				<h3 class="signature"><a name="Twitter($config=False)"></a><span class="static"></span> <span class="name">Twitter($config=False)</span> </h3>
			<p class="description"><em>Class Constructor</em></p> 
				<p class="info">Sets up the Oauth consumers and other general cfg</p>
				<pre>$twitter = new Twitter($config);</pre>
			</div>
			
			<div class="method">
				<h3 class="signature"><a name="getRequestTokens()"></a><span class="static"></span> <span class="name">getRequestTokens()</span> </h3>
			<p class="description"><em>Obtain request tokens from Twitter</em></p> 
				<p class="info">Queries Twitter for some tokens to use in the Oauth exchange
			then stores them in a session for later</p>
				<pre>$twitter->getRequestTokens();</pre>
			</div>
			
			<div class="method">
				<h3 class="signature"><a name="sessionRequestTokens()"></a><span class="static"></span> <span class="name">sessionRequestTokens()</span> </h3>
			<p class="description"><em>Retrieve the Oauth Request Keys</em></p> 
				<p class="info">Gets the request keys out of the stored session and
			creates an Oauth consumer with them with which to make
			the Request/Access key trade</p>
				<pre>$twitter->sessionRequestTokens();</pre>
			</div>
			
			<div class="method">
				<h3 class="signature"><a name="tradeRequestForAccess()"></a><span class="static"></span> <span class="name">tradeRequestForAccess()</span> </h3>
			<p class="description"><em>Trades Request keys for user Access keys</em></p> 
				<p class="info">Makes an Oauth request to Twitter to trade the
			request keys for the users Access keys</p>
				<pre>$twitter->tradeRequestForAccess();</pre>
			</div>
			
			<div class="method">
				<h3 class="signature"><a name="storeTokens()"></a><span class="static"></span> <span class="name">storeTokens()</span> </h3>
			<p class="description"><em>Stores Access tokens</em></p> 
				<p class="info">Stores the users access tokens in the database
			and creates a cookie to persist the login
			if set to do so in the cfg</p>
				<pre>$twitter->storeTokens();</pre>
			</div>
			
			<div class="method">
				<h3 class="signature"><a name="revokeSession($delete_keys=False)"></a><span class="static"></span> <span class="name">revokeSession($delete_keys=False)</span> </h3>
			<p class="description"><em>Revoke the current Session</em></p> 
				<p class="info">Delete any stored session data. Otionally delete
			any stored keys for the current user</p>
				<pre>$twitter->revokeSession($delete_keys);</pre>
			</div>
			
			<div class="method">
				<h3 class="signature"><a name="getUrl($type,$token=False)"></a><span class="static"></span> <span class="name">getUrl($type,$token=False)</span> </h3>
			<p class="description"><em>Retrieve an API formatted URL</em></p> 
				<p class="info">Constructs a url in the correct Twitter API form.</p>
				<pre>$twitter->getUrl($type, $token);</pre>
			</div>
			
			<div class="method">
				<h3 class="signature"><a name="getAuthorizeUrl()"></a><span class="static"></span> <span class="name">getAuthorizeUrl()</span> </h3>
			<p class="description"><em>Construct Authorize URL</em></p> 
				<p class="info">Returns a formatted API url for making initial auth request
			(convenience function)</p>
				<pre>$twitter->getAuthorizeUrl();</pre>
			</div>
			
			<div class="method">
				<h3 class="signature"><a name="check_login()"></a><span class="static"></span> <span class="name">check_login()</span> </h3>
			<p class="description"><em>Check for a current login</em></p> 
				<p class="info">Check if there is a user access key/secret for us to load
			From session or cookie (currently cookie is unimplemented)</p>
				<pre>$twitter->check_login();</pre>
			</div>
			
			<div class="method">
				<h3 class="signature"><a name="oAuthParseResponse($responseString)"></a><span class="static"></span> <span class="name">oAuthParseResponse($responseString)</span> </h3>
			<p class="description"><em>Parse a URL-encoded OAuth response</em></p> 
				<p class="info">Takes an Oauth URL coded response and converts it into an array format</p>
				<pre>$this->oAuthParseResponse($responseString);</pre>
			</div>
			
			<div class="method">
				<h3 class="signature"><a name="oAuthRequest($url, $args = array(), $method = NULL)"></a><span class="static"></span> <span class="name">oAuthRequest($url, $args = array(), $method = NULL)</span> </h3>
			<p class="description"><em>Format and sign an OAuth / API request</em></p> 
				<pre>$this->oAuthRequest($url, $args, $method);</pre>
			</div>
			
			<div class="method">
				<h3 class="signature"><a name="http($url, $post_data = null)"></a><span class="static"></span> <span class="name">http($url, $post_data = null)</span> </h3>
			<p class="description"><em>Make an HTTP request</em></p> 
				<p class="info">Uses Curl to retrieve a specified URL and return the page content if successful</p>
				<pre>$this->http($url, $post_data);</pre>
			</div>
			
			<div class="method">
				<h3 class="signature"><a name="setStatus($message)"></a><span class="static"></span> <span class="name">setStatus($message)</span> </h3>
			<p class="description"><em>Set Twitter Status</em></p> 
				<p class="info">API Call: updates the status of the current Twitter user to
			$message contents</p>
				<pre>$twitter->setStatus($message);</pre>
			</div>
			
			<div class="method">
				<h3 class="signature"><a name="getReplies( $args = array(), $type = 'json')"></a><span class="static"></span> <span class="name">getReplies( $args = array(), $type = 'json')</span> </h3>
			<p class="description"><em>Get Replies</em></p> 
				<p class="info">API Call: Retrieve the current users 
			Twitter API options as arguments)</p>
				<pre>$this->getReplies($args, $type);</pre>
			</div>
			
			<div class="method">
				<h3 class="signature"><a name="getStatus( $args = array(), $type = 'json')"></a><span class="static"></span> <span class="name">getStatus( $args = array(), $type = 'json')</span> </h3>
			<p class="description"><em>Get Status</em></p> 
				<p class="info">API Call: Retrieve the current users statuses (allows passing
			Twitter API options as arguments)</p>
				<pre>$this->getStatus($args, $type);</pre>
			</div>
			
			<div class="method">
				<h3 class="signature"><a name="rateLimitStatus()"></a><span class="static"></span> <span class="name">rateLimitStatus()</span> </h3>
			<p class="description"><em>Get Rate Limits</em></p> 
				<p class="info">API Call: Retrieve information on the remaing API rate limits</p>
				<pre>$twitter->rateLimitStatus();</pre>
			</div>
		</div>
	</div>
	
	

</div>
