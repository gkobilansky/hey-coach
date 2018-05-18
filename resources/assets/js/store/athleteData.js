export default {
  namespaced: true,
  state: {
    recruits: {},
    recruitingStatuses: {},
    schools: {}
  },
  mutations: {
    setRecruitList: (state, { list }) => {
      state.recruits = list;
    },
    setStatusList: (state, { list }) => {
      state.recruitingStatuses = list;
    },
    setSchoolList: (state, { list }) => {
      state.schools = list;
    }
  },
  actions: {
    getRecruitList({ commit }) {
      axios
        .get("/recruits/athleteData")
        .then(response => {
          console.log(response);
          commit("setRecruitList", { list: response.data });
        })
        .catch(error => {
          console.log(errpr);
        });
    },
    /*
      Adds a recruit
      https://serversideup.net/build-api-requests-javascript/
      https://github.com/serversideup/roastandbrew
      https://serversideup.net/api-form-submissions-javascript-vuex-laravel/
    */
    addRecruit({ commit, state, dispatch }, data) {},
    createRecruit({ commit }) {
      axios
        .post("/recruits/add")
        .then(response => {
          console.log(response);
          commit("setRecruitList", { list: response.data });
        })
        .catch(error => {
          console.log(errpr);
        });
    },
    updateRecruitStatus({ commit, state, dispatch }, data) {
      axios
        .patch(
          "recruits/updatestatus",
          {
            id: data.block,
            status_id: data.stage
          },
          {}
        )
        .then(response => {
          dispatch("getRecruitList");
        })
        .catch(error => {
          console.log(errpr);
        });
    },
    getStatusList({ commit }) {
      axios
        .get("/statuses")
        .then(response => {
          commit("setStatusList", { list: response.data.data });
        })
        .catch(error => {
          console.log(errpr);
        });
    },
    getSchoolsList({ commit }) {
      //get list
      axios
        .get("/athletes/data")
        .then(response => {
          let athleteDataArray = response.data.data;
          let schoolsArray = athleteDataArray.map(
            athlete => athlete.company_name
          );
          commit("setSchoolList", { list: [...new Set(schoolsArray)] });
        })
        .catch(error => {
          console.log(errpr);
        });
    }
  }
};
