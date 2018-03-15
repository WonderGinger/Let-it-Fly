<?php
echo <<<_END
<!-- Driver/Rider status card -->
<div class="row card">

  <!-- Current Status Card -->
  <form class="col s10 offset-s1 card-content black-text" id="status-text" method="POST">
    <div class="card-title">Welcome, Bob</div>
    
    <!-- Status Card Header --> 
    <div class="card-message">Please select your route options.</div>

    
    <!-- From field -->
    <div class="row">
      <div class="input-field col s12">
        <input id="from" name="from" >
        <label for="start-loc">Starting Location</label>
      </div>
    </div>

    <!-- To field -->
    <div class="row">
      <div class="input-field col s12">
        <input id="to" name="to">
        <label>End Location</label>
      </div>
    </div>

    <!-- Go Button -->
    <div class="row">
      <button class="btn waves-effect waves-light" type="go" id="go" name="submit">Go
          <i class="material-icons right">send</i>
      </button>
    </div>
  </form>

  <!-- Looks like the map should go here --> 

</div>
_END;


/* USAGE: 
 *  Currently a test version of the code using
 *  only my local test server with a test table.
 *  This can be adapter once the backend is officially created.
 *    Additionally, some of this validation should be done in JavaScript 
 *    rather than using php's die function.
 */
 
?>