const MAX_FIELDS = 20;

/**
 * Get all fields
 */
const getFields = (container) => {
  return [...container.querySelectorAll(".dynamic__field")];
};

/**
 * Get visible fields
 */
const getVisibleFields = (container) => {
  return getFields(container).filter((field) =>
    field.classList.contains("add")
  );
};

/**
 * Show next hidden field
 */
const addDynamicField = (container, addBtn) => {
  const fields = getFields(container);
  const hiddenField = fields.find(
    (field) => !field.classList.contains("add")
  );

  if (!hiddenField) return;

  hiddenField.classList.add("add");
  hiddenField.classList.remove("remove");

  // Hide add button if max reached
  if (getVisibleFields(container).length >= MAX_FIELDS) {
    addBtn.style.display = "none";
  }
};

/**
 * Hide current field
 */
const removeDynamicField = (field, container, addBtn) => {
  const visibleFields = getVisibleFields(container);

  // keep at least 1 visible
  if (visibleFields.length <= 1) return;

  field.classList.remove("add");
  field.classList.add("remove");

  // show add button again if it was hidden
  if (visibleFields.length <= MAX_FIELDS) {
    addBtn.style.display = "inline-flex";
  }
};

/**
 * Setup handlers
 */
const setupDynamicFieldHandlers = (wrapper) => {
  if (!wrapper) return;

  const container = wrapper.querySelector(".dynamic__fields__body");
  const addBtn = wrapper.querySelector(".dynamic__fields__header button");

  // ADD
  addBtn.addEventListener("click", () => {
    addDynamicField(container, addBtn);
  });

  // REMOVE (delegation)
  container.addEventListener("click", (e) => {
    const removeBtn = e.target.closest(".dynamic__field__remover");
    if (!removeBtn) return;

    const field = removeBtn.closest(".dynamic__field");
    removeDynamicField(field, container, addBtn);
  });
};

/**
 * INIT
 */
const DynamicFields = () => {
  const wrappers = document.querySelectorAll(".dynamic__fields__container");

  wrappers.forEach(setupDynamicFieldHandlers);
};

export default DynamicFields;
