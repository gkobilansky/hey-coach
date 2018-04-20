export default {
  namespaced: true,
  state: {
    recruitingStatuses: {},
    schools: {}
  },
  mutations: {
    setStatusList: (state, { list }) => {
      state.recruitingStatuses = list;
    },
    setSchoolList: (state, { list }) => {
      state.schools = list;
    }
  },
  actions: {
    getStatusList({ commit }) {
      axios.get("/statuses").then(
        response => {
          commit("setStatusList", { list: response.data.data });
        },
        response => {
          // error callback
          console.log(response);
        }
      );
    },
    getSchoolsList({ commit }) {
      //get list
      axios.get("/athletes/data").then(
        response => {
          let athleteDataArray = response.data.data;
          let schoolsArray = athleteDataArray.map(
            athlete => athlete.company_name
          );
          commit("setSchoolList", { list: [...new Set(schoolsArray)] });
        },
        response => {
          // error callback
          console.log(e);
        }
      );
    }
  }
};
