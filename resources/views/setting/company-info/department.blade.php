@section('departmentHtml')

<!-- Department -->
  <div id="department" class="col l12 pad-20 tab-content">
    <div class="row">
      <p class="titleB01">Department</p>
      <hr class="mt10 mb20">
      <!-- <div class="col l12">
        <a href="#!" class="btn btnB01 mr5">Export</a>
        <a href="#!" class="btn btnB01">Import</a>
      </div> -->

      <!-- Kiri -->
      <div class="col l6">
        <div class="row">
          {!! Form::open(array('url' => route('setting.department.add'),'class' => 'formJobDep', 'data-type' => 'departement')) !!}
          <div class="col l12 input-field">
            <?= Form::text('name',null,array('id'=>'name_departement','class'=>'validate enter inputTree')) ?>
            <label for="name_departement">Department Name</label>
          </div>
          <div class="col l12 input-field">
            <?= Form::select('parent_id_fk', UserService::getListDepartment(),null,['id'=>'parent_id_fk_dept','class'=>'validate enter selectParent']); ?>
            <label for="parent_id_fk_dept">Parent</label>
          </div>
          <div class="col l12 right-align">
            <a href="#!" class="btn btnB01 saveTree">Add</a>
          </div>
          <input class="text_success" type="hidden" value="Add Department Successfull"/>
          {!! Form::close()!!}
        </div>
      </div>

    <!-- Kanan -->
      <div class="col l6">
        <form>
          <!-- PERHATIAN ! NAMA ID HARUS MENGANDUNG "_" -->
          <ul id="list_structure_organization" class="tree">
            <!-- PERHATIAN ! NAMA ID HARUS MENGANDUNG "_" dan berisi angka -->
            @each('partials.tree', $departments,'data')
          </ul>
        </form>
      </div>
    </div>
  </div>
@endsection
