<!-- Content -->
<div class="card">
  <!-- Search interface -->
  <div class="container">
    <div id="floating-panel">
      <div class="row">
        <div class="col s12 m8 offset-m2 input-field">
          <!-- Search card -->
          <div class="card-panel">
            <input class="autocomplete" type="text" id="autocomplete-input" placeholder="Search">
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Map -->
  <div id="map"></div>
  <div class="card-content activator" id="slider">
    <span class="card-title activator center-align teal-text lighten-1">Choose Your Location<i class="material-icons">keyboard_arrow_up</i></span>
  </div>
  <!-- Request Interface -->
  <div class="card-reveal grey lighten-3">
    <span class="card-title center-align teal-text lighten-1">Request a Ride<i class="material-icons">keyboard_arrow_down</i></span>
    <div class="container">
      <div class="row">
        <!-- Request Details -->
        <div class="col s12 m7" id="details">
          <div class="card">
            <div class="card-content">
              <h6 class="teal-text lighten-1">Route</h6>
              <i class="material-icons red-text" id="indicator">location_on</i>
              <div class="input-field inline">
                <input type="text" id="disabled" value="Location has not been chosen yet" disabled>
              </div>
              <i class="material-icons blue-text" id="indicator">my_location</i>
              <div class="input-field inline">
                <select id="airport-select">
                  <option value="" disabled selected>Select an airport</option>
                  <option value="SFO">San Francisco (SFO)</option>
                  <option value="OAK">Oakland (OAK)</option>
                  <option value="SJC">San Jose (SJC)</option>
                </select>
              </div>
              <div class="switch">
                <label><input type="checkbox" name="checkbox"><span class="lever"></span>Swap directions</label>
              </div>
              <h6 class="teal-text lighten-1">Passenger Count</h6>
            </div>
          </div>
        </div>
        <!-- Request Submission -->
        <div class="col s12 m5" id="submission">
          <div class="card">
            <div class="card-content">
              <h6 class="teal-text lighten-1">Ride Cost</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>