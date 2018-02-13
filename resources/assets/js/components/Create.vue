<template>
<div class="create">
<el-button id="add-recruit" type="primary" @click="dialogFormVisible = true" round>Add New Recruit</el-button>

<el-dialog title="Add New Recruit" :visible.sync="dialogFormVisible">
  <el-form v-model="form">
    <el-form-item label="Athlete Name" :label-width="formLabelWidth">
      <el-input v-model="form.name" auto-complete="off"></el-input>
    </el-form-item>
    <el-form-item label="School or Club Name" :label-width="formLabelWidth">
       <el-autocomplete
        v-model="form.company_name"
        class="inline-input"
        :fetch-suggestions="querySearch"
        placeholder="Please Input"
        :trigger-on-focus="true"
        @select="handleSelect"
      ></el-autocomplete>
    </el-form-item>
    <el-form-item label="Athlete Email" :label-width="formLabelWidth">
      <el-input v-model="form.email" auto-complete="off"></el-input>
    </el-form-item>
  </el-form>
  <span slot="footer" class="dialog-footer">
    <el-button @click="dialogFormVisible = false">Cancel</el-button>
    <el-button type="primary" @click="addAthlete">Confirm</el-button>
  </span>
</el-dialog>
</div>

</template>

<script>
export default {
    name: 'create',
    data() {
      return {
        form: {
          name: '',
          company_name: '',
          email: ''
        },
        dialogFormVisible: false,
        formLabelWidth: '120px',
        schools: []
      };
    },
    methods: {
      querySearch(queryString, cb) {
        let schools = [
         {"value": "Blair"},
         {"value": "St. Francis"}, 
         {"value": "Xavier"}
         ];

        let results  = queryString ? schools.filter(this.createFilter(queryString)) : schools;

        cb(results);
      },
      createFilter(queryString) {
        return (school) => {
          return (school.value.toLowerCase().indexOf(queryString.toLowerCase()) === 0);
        };
      },
      addAthlete: function(event) {
        this.dialogFormVisible = false;

        console.log(this.form);

        let data =  {
          name: 'Jason Nolf',
          company_name: 'Blair',
          state: 'NJ',
          email: 'jason@blair.edu',
          user_id: '1',
          industry_id: '1'
        }

        console.log(data)
        
        this.$http.post('/athletes/store', data).then(this.successCallback, this.errorCallback);
      },
      successCallback: (r) => {
          console.log('success', r)

        },
      errorCallback(e) {
          console.log(e)
        },
      handleSelect(item) {
       // console.log(item);
      }
    }
  };
</script>
