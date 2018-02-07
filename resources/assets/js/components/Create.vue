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
        v-model="state"
        class="inline-input"
        :fetch-suggestions="querySearch"
        placeholder="Please Input"
        :trigger-on-focus="true"
        @select="handleSelect"
      ></el-autocomplete>
    </el-form-item>
  </el-form>
  <span slot="footer" class="dialog-footer">
    <el-button @click="dialogFormVisible = false">Cancel</el-button>
    <el-button type="primary" @click="dialogFormVisible = false">Confirm</el-button>
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
          organization: '',
        },
        state: '',
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
        console.log(results);

        // let resource = this.$resource('athletes/data')
        // resource.get().then(this.successCallback, this.errorCallback);
        // call callback function to return suggestions

        cb(results);

      },
      createFilter(queryString) {
        return (school) => {
          return (school.value.toLowerCase().indexOf(queryString.toLowerCase()) === 0);
        };
      },
      successCallback: (r) => {
          console.log('success', r.body.data)
           
          //let data = r.body.data;           
          // for (var i = 0; i < data.length; i++) {
          //     this.schools.push(data[i].company_name.toLowerCase());
          //     console.log("school " + i + ": " + data[i].company_name);
          // }

        },
      errorCallback(e) {
          console.log(e)
        },
      handleSelect(item) {
        console.log(item);
      }
    }
  };
</script>
