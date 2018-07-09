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
        .get("/recruits/recruitDataBySchool")
        .then(response => {
          commit("setRecruitList", {
            list: response.data
          });
        })
        .catch(error => {
          console.log(error);
        });
    },
    createRecruit({ commit, state, dispatch }, data) {
      let date = Date.now();
      let recruitData = {
        title: "Test Title",
        description: "test description",
        status: data.data.status_id,
        user_assigned_id: data.data.user_id,
        athlete_id: null,
        user_created_id: data.data.user_id,
        contact_date: date
      };
      axios
        .post("/athletes/store", data.data)
        .then(response => {
          recruitData.athlete_id = response.data.last_insert_id;
          axios
            .post("/recruits/store", recruitData)
            .then(response => {
              dispatch("getRecruitList");
              console.log("recruit stored", response);
            })
            .catch(error => {
              console.log(error);
            });
        })
        .catch(error => {
          console.log(error);
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
          console.log(error);
        });
    },
    getStatusList({ commit }) {
      axios
        .get("/statuses")
        .then(response => {
          commit("setStatusList", {
            list: response.data.data
          });
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
          commit("setSchoolList", {
            list: [...new Set(schoolsArray)]
          });
        })
        .catch(error => {
          console.log(error);
        });
    }
  }
};
