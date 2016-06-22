<!-- schedule -->
  <div id="schedule" class="col l12 pad-20 tab-content">
    <div class="row">
      <p class="titleB01">Schedule</p>
      <hr class="mt10 mb20">
      <div class="col l8 input-field">
        <input type="text" id="schName">
        <label for="schName">Schedule Name</label>
      </div>
      <div class="col l8 input-field">
        <select id="schPattern">
          <option>--Select Pattern--</option>
        </select>
        <label for="schPattern">Pattern</label>
      </div>
      <div class="col l8 input-field">
        <input type="text" id="schDate" class="calendar">
        <label for="schDate">Effective Date</label>
      </div>
      <div class="col l8 input-field">
        <select id="schShift">
          <option>--Select Initial Shift--</option>
        </select>
        <label for="schShift">Initial Shift</label>
      </div>
      <div class="col l12 input-field">
        <input type="checkbox" id="overideNH" class="filled-in">
        <label for="overideNH">Overide National Holiday</label>
      </div>
      <div class="col l12 input-field">
        <input type="checkbox" id="overideCH" class="filled-in">
        <label for="overideCH">Overide Company Holiday</label>
      </div>
      <div class="col l12 input-field">
        <input type="checkbox" id="flexible" class="filled-in">
        <label for="flexible">Flexible
          <a class="tooltip2 tooltip2-right">
            <i class="fa fa-info-circle"></i>
            <span class="left-align f10 mb5">
            <p>Flexible means you can come anytime as long as //tooltiped </p>
          </span>
          </a>
        </label>
      </div>
      <div class="col l12 mt40 right-align">
      <a href="#!" class="btn btnB01">Save & add schedule</a>
      </div>
      <div class="col l12 mt40">
        <table class="bordered">
          <thead class="grey lighten-3 bold">
            <tr>
              <td>Name</td>
              <td>Pattern</td>
              <td>Initial Shift</td>
              <td>Flexible</td>
              <td>Effective Date</td>
              <td>Action</td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Test 123</td>
              <td>Talenta Pattern 2</td>
              <td>A</td>
              <td>Yes</td>
              <td>2015-09-30</td>
              <td>
                <a href="#!" class="bold red1-text" data-tooltip="Set as Default"><i class="fa fa-check"></i></a>&nbsp;
                <a href="#!" class="bold red1-text" data-tooltip="Detail"><i class="fa fa-list"></i></a>&nbsp;
                <a href="#!" class="bold red1-text" data-tooltip="Remove"><i class="fa fa-trash"></i></a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
