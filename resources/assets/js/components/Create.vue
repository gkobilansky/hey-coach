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
          status_id: '2',
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
          this.$http.get('/athletes/data').then(response => {
            let athleteDataArray = response.body.data;
            const uniqueSchools = athleteDataArray.map(function(athlete){
                return {
                  "value": athlete.company_name
                }
              }
            );
            this.schools = uniqueSchools;
          }, response => {
            // error callback
            console.log(e);
          });

        // grab list. if theres nothing in the form, return whole list
        let schools = this.schools;
        let results  = queryString ? schools.filter(this.createFilter(queryString)) : schools;
        cb(results);
      },
      suggestStatuses(queryString, cb) {
           //get list 
          this.$http.get('/statuses').then(response => {
            let statusDataArray = response.body.data;
            const uniqueStatuses = statusDataArray.map(function(status){
                return {
                  "value": status.name
                }
              }
            );
            this.statuses = uniqueStatuses;
            console.log(this.statuses)
          }, response => {
            // error callback
            console.log(response);
          });

        // grab list. if theres nothing in the form, return whole list
        let statuses = this.statuses;
        let results  = queryString ? statuses.filter(this.createFilter(queryString)) : statuses;
        cb(results);

      },
      createFilter(queryString) {
        return (obj) => {
          return (obj.value.toLowerCase().indexOf(queryString.toLowerCase()) === 0);
        };
      },
      addAthlete: function(event) {
        this.dialogFormVisible = false;
      
        this.$http.post('/athletes/store', this.form).then(response => {
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

          this.$http.post('/recruits/store', recruitData).then(response => {
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
