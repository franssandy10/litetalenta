@section('jobpositionHtml')
<!-- Job Position -->
<div id="jobPos" class="col l12 pad-20 tab-content">
  <div class="row">
    <p class="titleB01">Job Position</p>
    <hr class="mt10 mb20">
    <!-- <div class="col l12">
      <a href="#!" class="btn btnB01 mr5">Export</a>
      <a href="#!" class="btn btnB01">Import</a>
    </div> -->
    <!-- Kiri -->
    <div class="col l6">
      <div class="row">
        {!! Form::open(array('url' => route('setting.job.add'), 'class' => 'formJobDep', 'data-type' => 'job')) !!}
        <div class="col l12 input-field">
          <?= Form::text('name',null,array('id'=>'name','class'=>'validate enter inputTree')) ?>
          <label for="name">Job Position Name</label>
        </div>
        <div class="col l12 input-field">
          <?= Form::select('parent_id_fk', UserService::getListJobPosition(),null,['id'=>'parent_id_fk','class'=>'validate enter selectParent']); ?>
          <label for="jobTitle">Parent</label>
        </div>
        <div class="col l12 right-align">
          <a href="#!" class="btn btnB01 saveTree">Add</a>
        </div>
        <input class="text_success" type="hidden" value="Add Job Position Successfull"/>
        {!! Form::close()!!}

      </div>
    </div>

  <!-- Kanan -->
    <div class="col l6">
      <form>
        <!-- PERHATIAN ! NAMA ID HARUS MENGANDUNG "_" -->
        <ul id="list_job_position" class="tree">
          @each('partials.tree', $jobs,'data')
        </ul>
      </form>
    </div>
  </div>
</div>

@endsection
