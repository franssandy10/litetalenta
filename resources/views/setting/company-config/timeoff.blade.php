@section('timeoffHtml')

  <!-- timeoff -->
  <div id="timeoff" class="col l12 pad-20 tab-content">

    <!-- Add New Time Off Policy -->
    <div id="newTimeOffPolicy" class="displayNone">
      <div class="row">
        <p class="titleB01">Time off policy</p>
        <hr class="mt10 mb20">

        <div class="col l4 input-field">
          <input type="text" id="policyCode">
          <label for="policyCode">Policy Code</label>
        </div>
        <div class="col l8 input-field">
          <input type="text" id="policyName">
          <label for="policyName">Policy Name</label>
        </div>
        <div class="col l4 input-field">
          <input type="text" id="timeoffEffective" class="datepicker">
          <label for="timeoffEffective">Effective as of</label>
        </div>
        <div class="clearfix"></div>
        <div class="col l6 input-field">
          <input type="checkbox" class="filled-in" id="unlimitedTO">
          <label for="unlimitedTO">This policy has unlimited time off</label>
        </div>
        <div class="clearfix"></div>
        <div class="col l6 input-field">
          <input type="checkbox" class="filled-in" id="defaultTO">
          <label for="defaultTO">Default time off for new employee</label>
        </div>
      </div>
      <hr class="mb40">
      <div class="row">
        <!-- Kiri -->
        <div class="col l6 bRight">
          <div class="row">
            <div class="col l12 input-field">
              <select>
                <option>Anniversary</option>
                <option>Monthly</option>
                <option>Annually</option>
              </select>
              <label>Policy Type</label>
            </div>

            <div class="col l12 input-field">
              <input type="checkbox" class="filled-in" id="firstEmmerge">
              <label for="firstEmmerge">First Emmerge</label>
            </div>
            <div class="col l12 input-field">
              <input type="checkbox" class="filled-in" id="effectiveFrom">
              <label for="effectiveFrom">Effective from Join Date</label>
            </div>
            <div class="col l6 input-field mt40">
              <input type="radio" class="with-gap" id="emmergeAfter">
              <label for="emmergeAfter">Emmerge After</label>
            </div>
            <div class="col l6 input-field mt40">
              <input type="text" class="with-gap" id="mnths">
              <label for="mnths">Month(s)</label>
            </div>

            <div class="col l12 input-field">
              <input type="radio" class="with-gap" id="firstEmmergeStatus">
              <label for="firstEmmergeStatus">First Emmerge Status</label>
            </div>

            <div class="col l12 input-field">
              <select multiple id="emmergeStatus">
                <option>Fulltime</option>
                <option>Contract</option>
                <option>Probation</option>
              </select>
            </div>
          </div>
        </div>
        <div class="col l6">
          <p class="bold">Expired</p>
          <div class="row">

            <!-- Expired in Month -->
            <div class="col l1 input-field">
              <input type="radio" class="with-gap" id="expMth">
              <label for="expMth"></label>
            </div>
            <div class="col l5 input-field">
              <input type="number" id="mth">
              <label for="mth">In Month(s)</label>
            </div>
            <div class="clearfix"></div>

            <!-- Expired in Day and Month -->
            <div class="col l1 input-field">
              <input type="radio" class="with-gap" id="expDay">
              <label for="expDay"></label>
            </div>
            <div class="col l3 input-field">
              <input type="number" id="day">
              <label for="day">Day</label>
            </div>
            <div class="col l5 input-field">
              <select>
                <option>January</option>
              </select>
            </div>
            <div class="clearfix"></div>

          <!-- No Expiry Date -->
            <div class="col l12 input-field">
              <input type="radio" class="with-gap" id="noexpDay">
              <label for="noexpDay">No Expiry Date</label>
            </div>

            <div class="col l12 mt40">
              <table class="bordered">
                <thead class="grey lighten-3">
                  <tr>
                    <td width="50" class="center-align">From</td>
                    <td width="50" class="center-align"></td>
                    <td width="50" class="center-align">To</td>
                    <td width="50" class="center-align"></td>
                    <td width="250" class="center-align">Rounding</td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="center-align">
                      <input type="text">
                    </td>
                    <td class="center-align">
                      -
                    </td>
                    <td class="center-align">
                      <input type="text">
                    </td>
                    <td class="center-align">
                      =
                    </td>
                    <td class="center-align">
                      <div class="col l12">
                        <select>
                          <option>Round Down</option>
                        </select>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <hr class="mb40">
      <div class="row">
        <div class="col l6">
            <table class="bordered">
              <thead class="grey lighten-3">
                <tr>
                  <td class="center-align">From</td>
                  <td class="center-align"></td>
                  <td class="center-align">To</td>
                  <td class="center-align"></td>
                  <td class="center-align">Equal</td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="center-align">
                    <input type="text">
                  </td>
                  <td class="center-align">
                    -
                  </td>
                  <td class="center-align">
                    <input type="text">
                  </td>
                  <td class="center-align">
                    =
                  </td>
                  <td class="center-align">
                    <input type="text">
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
      </div>
      <div class="row">
        <div class="col l12 right-align">
          <a href="#!" class="btn btnB01">Save</a>
        </div>
      </div>
    </div>
  </div>
@endsection
