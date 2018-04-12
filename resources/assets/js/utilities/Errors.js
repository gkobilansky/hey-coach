class Errors {
  /* Create a new Errors instance */
  constructor() {
    this.errors = {};
  }

  /* Determine if an error exists for given field */
  has(field) {
    return this.errors.hasOwnProperty(field);
  }

  /* Determine if we have any errors */
  any() {
    return Object.keys(this.errors).length > 0;
  }

  /* Retrieve the erorr message for a field */
  get(field) {
    if (this.errors[field]) {
      return this.errors[field][0];
    }
  }

  /*  Record the new errors */
  record(errors) {
    this.errors = errors.errors;
  }

  /**
   *  Clear one or all fields
   *
   * @param {string|null} field
   */
  clear(field) {
    if (field) {
      delete this.errors[field];
      return;
    }

    this.errors = {};
  }
}

export default Errors;
