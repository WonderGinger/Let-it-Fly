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
    <span class="card-title center-align teal-text lighten-1" id="tabu">Request a Ride<i class="material-icons">keyboard_arrow_down</i></span>
    <div class="container">
      <div class="row">
        <!-- Request Details -->
        <div class="col s12 m6" id="details">
          <div class="card">
            <div class="card-content">
              <h6 class="teal-text lighten-1">Route</h6>
              <i class="material-icons red-text" id="indicator1">location_on</i>
              <div class="input-field inline">
                <input type="text" id="disabled" value="Location has not been chosen yet" disabled>
              </div>
              <i class="material-icons blue-text" id="indicator2">my_location</i>
              <div class="input-field inline">
                <select id="airport-select">
                  <option value="" disabled selected>Select an airport</option>
                  <option value="SFO">San Francisco (SFO)</option>
                  <option value="OAK">Oakland (OAK)</option>
                  <option value="SJC">San Jose (SJC)</option>
                </select>
              </div>
              <div class="switch">
                <label><input type="checkbox" id="switch" name="checkbox"><span class="lever"></span>Swap directions</label>
              </div>
              <h6 class="teal-text lighten-1">Passenger Count</h6>
              <p class="range-field"><input type="range" id="range" min="1" max="4" value="1"></p>
            </div>
          </div>
        </div>
        <!-- Request Submission -->
        <div class="col s12 m6" id="submission">
          <div class="card">
            <div class="card-content">
              <h6 class="teal-text lighten-1">Ride Details</h6>
              <table>
                <colgroup>
                  <col width="0%">
                  <col width="100%">
                </colgroup>
                <tr>
                  <td class="grey-text">Starting point</td>
                  <td class="data red-text" id="td1">Unspecified</td>
                </tr>
                <tr>
                  <td class="grey-text">Destination</td>
                  <td class="data red-text" id="td2">Unspecified</td>
                </tr>
                <tr>
                  <td class="grey-text">Distance</td>
                  <td class="data red-text" id="td7">Unknown</td>
                </tr>
                <tr>
                  <td class="grey-text">Duration</td>
                  <td class="data red-text" id="td4">Unknown</td>
                </tr>
                <tr>
                  <td class="grey-text">Wait Time</td>
                  <td class="data red-text" id="td5">Unknown</td>
                </tr>
                <tr>
                  <td class="grey-text">Passenger(s)</td>
                  <td class="data" id="td3">1</td>
                </tr>
                <tr>
                  <td class="grey-text">Cost</td>
                  <td class="data" id="td6">$0</td>
                </tr>
              </table>

              <div class="row">
                <div class="col s12">
                  <button class="btn waves-effect waves-light yellow darken-2 disabled" type="submit" id="update">Update</button>
                </div>
                <div class="col s12"><button class="btn waves-effect waves-light green disabled" type="submit" id="confirm">Confirm</button></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <p id="ajax"></p>
    </div>
  </div>
</div>