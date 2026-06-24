const getDirectChildContainer = (branch) => {
  return Array.from(branch.children).find((el) =>
    el.classList?.contains("branch__container")
  );
};

const getRow = (branch) => {
  return Array.from(branch.children).find((el) =>
    el.classList?.contains("branch__row")
  );
};

const getButton = (branch) => {
  return getRow(branch)?.querySelector(".branch__button") || null;
};

const getRadio = (branch) => {
  return getRow(branch)?.querySelector('input[type="radio"]') || null;
};

const updateBranchState = (branch) => {
  const childContainer = getDirectChildContainer(branch);
  const button = getButton(branch);

  const hasChildren =
    !!childContainer &&
    Array.from(childContainer.children).some((el) =>
      el.classList?.contains("branch")
    );

  branch.classList.toggle("is-parent", hasChildren);
  branch.classList.toggle("is-leaf", !hasChildren);
  branch.classList.toggle("branch--final", !hasChildren);

  if (button) {
    button.setAttribute("type", "button");
    button.setAttribute("role", "treeitem");

    if (hasChildren) {
      if (!childContainer.id) {
        childContainer.id = `branch-panel-${Math.random().toString(36).slice(2, 9)}`;
      }

      button.setAttribute("aria-controls", childContainer.id);

      if (!button.hasAttribute("aria-expanded")) {
        button.setAttribute("aria-expanded", "false");
      }

      if (!branch.classList.contains("is-open")) {
        childContainer.hidden = true;
      }
    } else {
      button.setAttribute("hidden", "");
    }
  }

  if (childContainer && !hasChildren) {
    childContainer.hidden = true;
  }
};

const toggleBranch = (branch) => {
  if (!branch.classList.contains("is-parent")) return;

  const childContainer = getDirectChildContainer(branch);
  const button = getButton(branch);
  if (!childContainer || !button) return;

  const willOpen = !branch.classList.contains("is-open");

  branch.classList.toggle("is-open", willOpen);
  childContainer.hidden = !willOpen;
  button.setAttribute("aria-expanded", String(willOpen));
};

const closeSiblingBranches = (branch) => {
  const parentContainer = branch.parentElement;
  if (!parentContainer) return;

  const siblings = Array.from(parentContainer.children).filter(
    (el) => el !== branch && el.classList?.contains("branch")
  );

  siblings.forEach((sibling) => {
    const childContainer = getDirectChildContainer(sibling);
    const button = getButton(sibling);

    sibling.classList.remove("is-open");
    if (childContainer) childContainer.hidden = true;
    if (button) button.setAttribute("aria-expanded", "false");
  });
};

const initBranchButton = (branch) => {
  const button = getButton(branch);
  if (!button || !branch.classList.contains("is-parent")) return;
  if (button.dataset.treeBound === "true") return;

  button.addEventListener("click", () => {
    closeSiblingBranches(branch);
    toggleBranch(branch);
  });

  button.addEventListener("keydown", (e) => {
    if (e.code === "Enter" || e.code === "Space") {
      e.preventDefault();
      closeSiblingBranches(branch);
      toggleBranch(branch);
    }
  });

  button.dataset.treeBound = "true";
};

const updateSelectedLeaf = (tree) => {
  const allBranches = tree.querySelectorAll(".branch");
  allBranches.forEach((branch) => branch.classList.remove("is-selected"));

  const checkedRadio = tree.querySelector('input[type="radio"]:checked');
  if (!checkedRadio) return;

  const selectedBranch = checkedRadio.closest(".branch");
  selectedBranch?.classList.add("is-selected");
};

const initLeafRadio = (branch, tree) => {
  const radio = getRadio(branch);
  if (!radio || !branch.classList.contains("is-leaf")) return;
  if (radio.dataset.treeBound === "true") return;

  radio.addEventListener("change", () => {
    updateSelectedLeaf(tree);
  });

  radio.dataset.treeBound = "true";
};

const prepareTree = (tree) => {
  const branches = Array.from(tree.querySelectorAll(".branch"));

  branches.forEach(updateBranchState);
  branches.forEach((branch) => initBranchButton(branch));
  branches.forEach((branch) => initLeafRadio(branch, tree));

  updateSelectedLeaf(tree);
};

const TreeRadio = () => {
  const trees = document.querySelectorAll(".tree");
  if (!trees.length) return;

  trees.forEach((tree) => {
    tree.setAttribute("role", "tree");
    prepareTree(tree);
  });
};

export default TreeRadio;
