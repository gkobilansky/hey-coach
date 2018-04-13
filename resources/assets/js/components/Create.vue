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
          user_id: '1',
          industry_id: '1'
        }),
        dialogFormVisible: false,
        schools: [],
        stateList: [
    { name: 'ALABAMA', abbreviation: 'AL'},
    { name: 'ALASKA', abbreviation: 'AK'},
    { name: 'AMERICAN SAMOA', abbreviation: 'AS'},
    { name: 'ARIZONA', abbreviation: 'AZ'},
    { name: 'ARKANSAS', abbreviation: 'AR'},
    { name: 'CALIFORNIA', abbreviation: 'CA'},
    { name: 'COLORADO', abbreviation: 'CO'},
    { name: 'CONNECTICUT', abbreviation: 'CT'},
    { name: 'DELAWARE', abbreviation: 'DE'},
    { name: 'DISTRICT OF COLUMBIA', abbreviation: 'DC'},
    { name: 'FEDERATED STATES OF MICRONESIA', abbreviation: 'FM'},
    { name: 'FLORIDA', abbreviation: 'FL'},
    { name: 'GEORGIA', abbreviation: 'GA'},
    { name: 'GUAM', abbreviation: 'GU'},
    { name: 'HAWAII', abbreviation: 'HI'},
    { name: 'IDAHO', abbreviation: 'ID'},
    { name: 'ILLINOIS', abbreviation: 'IL'},
    { name: 'INDIANA', abbreviation: 'IN'},
    { name: 'IOWA', abbreviation: 'IA'},
    { name: 'KANSAS', abbreviation: 'KS'},
    { name: 'KENTUCKY', abbreviation: 'KY'},
    { name: 'LOUISIANA', abbreviation: 'LA'},
    { name: 'MAINE', abbreviation: 'ME'},
    { name: 'MARSHALL ISLANDS', abbreviation: 'MH'},
    { name: 'MARYLAND', abbreviation: 'MD'},
    { name: 'MASSACHUSETTS', abbreviation: 'MA'},
    { name: 'MICHIGAN', abbreviation: 'MI'},
    { name: 'MINNESOTA', abbreviation: 'MN'},
    { name: 'MISSISSIPPI', abbreviation: 'MS'},
    { name: 'MISSOURI', abbreviation: 'MO'},
    { name: 'MONTANA', abbreviation: 'MT'},
    { name: 'NEBRASKA', abbreviation: 'NE'},
    { name: 'NEVADA', abbreviation: 'NV'},
    { name: 'NEW HAMPSHIRE', abbreviation: 'NH'},
    { name: 'NEW JERSEY', abbreviation: 'NJ'},
    { name: 'NEW MEXICO', abbreviation: 'NM'},
    { name: 'NEW YORK', abbreviation: 'NY'},
    { name: 'NORTH CAROLINA', abbreviation: 'NC'},
    { name: 'NORTH DAKOTA', abbreviation: 'ND'},
    { name: 'NORTHERN MARIANA ISLANDS', abbreviation: 'MP'},
    { name: 'OHIO', abbreviation: 'OH'},
    { name: 'OKLAHOMA', abbreviation: 'OK'},
    { name: 'OREGON', abbreviation: 'OR'},
    { name: 'PALAU', abbreviation: 'PW'},
    { name: 'PENNSYLVANIA', abbreviation: 'PA'},
    { name: 'PUERTO RICO', abbreviation: 'PR'},
    { name: 'RHODE ISLAND', abbreviation: 'RI'},
    { name: 'SOUTH CAROLINA', abbreviation: 'SC'},
    { name: 'SOUTH DAKOTA', abbreviation: 'SD'},
    { name: 'TENNESSEE', abbreviation: 'TN'},
    { name: 'TEXAS', abbreviation: 'TX'},
    { name: 'UTAH', abbreviation: 'UT'},
    { name: 'VERMONT', abbreviation: 'VT'},
    { name: 'VIRGIN ISLANDS', abbreviation: 'VI'},
    { name: 'VIRGINIA', abbreviation: 'VA'},
    { name: 'WASHINGTON', abbreviation: 'WA'},
    { name: 'WEST VIRGINIA', abbreviation: 'WV'},
    { name: 'WISCONSIN', abbreviation: 'WI'},
    { name: 'WYOMING', abbreviation: 'WY' }
],
        statuses: [],
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
        this.form
        .post('/athletes/store')
        .then(response => {
          let date = Date.now();
          const recruitData = {
            title: 'Test Title',
            description: 'test description',            
            status: this.form.status_id,
            user_assigned_id: this.form.user_id,
            athlete_id: response.last_insert_id,
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
