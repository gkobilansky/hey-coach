<template>
<div class="create">
<el-button id="add-recruit" type="primary" @click="dialogFormVisible = true" round>Add New Recruit</el-button>

<el-dialog title="Add New Recruit" :visible.sync="dialogFormVisible">
  <el-form v-model="form">
    <el-form-item label="Athlete Name">
      <el-input v-model="form.name" auto-complete="off"></el-input>
    </el-form-item>
    <el-form-item label="Athlete Email">
      <el-input v-model="form.email" auto-complete="off"></el-input>
    </el-form-item>
    <el-form-item label="School or Club Name">
       <el-autocomplete
        v-model="form.company_name"
        class="inline-input"
        :fetch-suggestions="suggestSchools"
        placeholder="Team X"
        :trigger-on-focus="true"
        @select="handleSelect"
      ></el-autocomplete>
    </el-form-item>
    <el-form-item label="Recruiting Status">
       <el-autocomplete
        v-model="form.status_id"
        class="inline-input"
        :fetch-suggestions="suggestStatuses"
        placeholder="Interested"
        :trigger-on-focus="true"
        @select="handleSelect"
      ></el-autocomplete>
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
          email: '',
          state: 'NY',
          status_id: '',
          user_id: '1',
          industry_id: '1'
        },
        dialogFormVisible: false,
        schools: [],
        statuses: []
      };
    },
    methods: {
      suggestSchools(queryString, cb) {

        //get list 
          axios.get('/athletes/data').then(response => {
            let athleteDataArray = response.data.data;
            let schoolsArray = athleteDataArray.map(athlete => athlete.company_name);
            this.schools = [...new Set(schoolsArray)]; 
            // this.schools = uniqueSchools.map(school => ({"name": school}))
          }, response => {
            // error callback
            console.log(e);
          });

        // grab list. if theres nothing in the form, return whole list
        let results  = queryString ? this.filterItems(queryString, this.schools) : this.schools;
        
        // results need to be objects with value
        results = results.map(result => ({"value" : result}))
        cb(results);
      },
      suggestStatuses(queryString, cb) {
           //get list 
          axios.get('/statuses').then(response => {
            this.statuses = response.data.data.map(status => status.name);
          }, response => {
            // error callback
            console.log(response);
          });

        // grab list. if theres nothing in the form, return whole list
        let results  = queryString ? this.filterItems(queryString, this.statuses) : this.statuses;
        
        // results need to be objects with value
        results = results.map(result => ({"value" : result}))
        cb(results);

      },
      filterItems(queryString, array) {
        return array.filter((el) =>
          el.toLowerCase().indexOf(queryString.toLowerCase()) > -1
        );
      },
      addAthlete: function(event) {
        this.dialogFormVisible = false;
      
        axios.post('/athletes/store', this.form).then(response => {
          let date = Date.now();
          const recruitData = {
            title: 'Test Title',
            description: 'test description',            
            status: this.form.status_id,
            user_assigned_id: this.form.user_id,
            athlete_id: response.data.last_insert_id,
            user_created_id: this.form.user_id,
            contact_date: date
          }

          console.log('stored athlete', response, recruitData);

          axios.post('/recruits/store', recruitData).then(response => {
            console.log('recruit stored', response)
            this.$bus.$emit('recruitCreated', response)
          }, this.errorCallback);
          
        }, this.errorCallback);

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
