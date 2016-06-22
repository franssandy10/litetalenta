@section('reactjs')
{!! Html::script('assets/js/react.js')!!}
{!! Html::script('assets/js/react-dom.js')!!}
<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.24/browser.min.js"></script>
@endsection
@section('reactfunction')
<!-- TODO: Current Tasks -->
<!--
<script type="text/babel">
var UserGist = React.createClass({
  getInitialState: function() {
    var employees=[];

    return { employees:employees};
  },

componentDidMount: function() {

  var employees=[];
  $.get(this.props.source, function(result) {
    // console.log(result.employees[0]);
    $.each(result.employees,function(x,y){
      employees.push(y);
    });
    this.setState({
      employees:employees
    });
    // console.log(employees);

  }.bind(this));
},

render: function() {
  console.log(this.props);
  return (
    <table className="bordered">
      <thead>
        <tr>
          <th>
            Employee ID
          </th>
          <th>
            Full Name
          </th>
          <th>
            Join Date
          </th>
        </tr>
      </thead>
      <tbody>
          {this.state.employees.map(function(arrayCell){
            console.log(arrayCell);
            return (
              <tr><td>{arrayCell.id}</td><td>{arrayCell.first_name} {arrayCell.last_name}</td><td>{arrayCell.join_date}</td></tr>
            )
          })
        }
      </tbody>
    </table>
  );
}
});

ReactDOM.render(
<UserGist source="{!! route('getemployee') !!}"/>,
document.getElementById('container')
);
</script>
-->
@endsection
