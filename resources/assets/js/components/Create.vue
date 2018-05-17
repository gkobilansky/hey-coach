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
    <el-form-item label="State">
      <el-select v-model="form.state" placeholder="Select State">
        <el-option
          v-for="item in stateList"
          :key="item.abbreviation"
          :label="item.name"
          :value="item.name">
        </el-option>
      </el-select>
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
        form: new Form({
          name: '',
          company_name: '',
          email: '',
          state: '',
          status_id: '',
          user_id: '1'
        }),
        dialogFormVisible: false
      };
    },
    computed:{
      stateList() {
        return this.$store.state.usStates.usStateList
      },
      statuses() {
        return this.$store.state.athleteData.recruitingStatuses
      },
      schools() {
        return this.$store.state.athleteData.schools
      }
    },
    mounted: function () {
      this.$store.dispatch('athleteData/getStatusList')
      this.$store.dispatch('athleteData/getSchoolsList')
    },
    methods: {
      suggestSchools(queryString, cb) {
        // grab list. if theres nothing in the form, return whole list
        let results  = queryString ? this.filterSchools(queryString, this.schools) : this.schools;
        
        // results need to be objects with value
        results = results.map(result => ({"value" : result}))
        cb(results);
      },
      suggestStatuses(queryString, cb) {
        // grab list. if theres nothing in the form, return whole list
        let results  = queryString ? this.filterStatus(queryString, this.statuses) : this.statuses;
        console.log(results)
        
        // results need to be objects with value
        results = results.map(result => ({"value" : result.name}))
        cb(results);

      },
      filterSchools(queryString, collection) {
       return _.filter(collection, o => {
          return  _.includes(o.toLowerCase(), queryString.toLowerCase())
        })
      },
      filterStatus(queryString, collection) {
       return _.filter(collection, o => { 
         return  _.includes(o.name.toLowerCase(), queryString.toLowerCase())
        })
      },

      addAthlete: function(event) {
        this.dialogFormVisible = false;
        let date = Date.now();
        const recruitData = {
            title: 'Test Title',
            description: 'test description',            
            status: this.form.status_id,
            user_assigned_id: this.form.user_id,
            athlete_id: null,
            user_created_id: this.form.user_id,
            contact_date: date
        }
        this.form
        .post('/athletes/store')
        .then(response => {
          recruitData.athlete_id = response.last_insert_id  
          console.log('recruit stored', response)

          axios
          .post('/recruits/store', recruitData)
          .then(response => {
              console.log('recruit stored', response)
            })
            .catch(error => {
            console.log(errpr); 
            })
        })
        .catch(error => {
          console.log(errpr);
        });
      },
      handleSelect(item) {
        console.log(item)
      }
    }
  };
</script>
