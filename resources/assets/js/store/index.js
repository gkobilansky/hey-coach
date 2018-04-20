import Vue from "vue";
import Vuex from "vuex";
import createPersistedState from "vuex-persistedstate";
import athleteData from "./athleteData";
import usStates from "./usStates";

Vue.use(Vuex);

export default new Vuex.Store({
  strict: true,
  modules: {
    athleteData,
    usStates
  },
  plugins: [createPersistedState()]
});
