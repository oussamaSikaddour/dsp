const toggleInert = (element, state = false) => {
  if (!element) return;

  const supportsInert = "inert" in HTMLElement.prototype;

  if (supportsInert) {
    state ? element.setAttribute("inert", "") : element.removeAttribute("inert");
  } else {
    if (state) {
      element.setAttribute("aria-hidden", "true");
      element.style.pointerEvents = "none";

      element
        .querySelectorAll("a, button, input, textarea, select, [tabindex]")
        .forEach((child) => {
          child.dataset.oldTabindex = child.getAttribute("tabindex");
          child.setAttribute("tabindex", "-1");
        });
    } else {
      element.removeAttribute("aria-hidden");
      element.style.pointerEvents = "";

      element.querySelectorAll("[data-old-tabindex]").forEach((child) => {
        const old = child.dataset.oldTabindex;

        if (old !== null) {
          child.setAttribute("tabindex", old);
        } else {
          child.removeAttribute("tabindex");
        }

        delete child.dataset.oldTabindex;
      });
    }
  }
};

/**
 * Toggle inert based on state
 */
export const toggleInertWhenState = (
  element,
  className,
  invertState = false
) => {
  if (!element) return;

  const isActive = element.classList.contains(className);
  toggleInert(element, invertState ? !isActive : isActive);
};

/**
 * Toggle inert for a child element
 */
export const toggleInertForChildElement = (
  parent,
  child,
  className,
  invertState = false
) => {
  if (!parent || !child) return;

  const isActive = parent.classList.contains(className);
  toggleInert(child, invertState ? !isActive : isActive);
};

/**
 * Makes all body children inert except:
 * - the opened element
 * - floating UI elements like combobox popups
 */
export const toggleInertForAllExceptOpenedElement = (
  openedElement,
  className,
  invertState = false
) => {
  if (!openedElement) return;

  const isActive = openedElement.classList.contains(className);
  const shouldInert = invertState ? !isActive : isActive;

  const excludedSelectors = [
    ".combobox__table__container",
    ".combobox__list"
  ];

  const bodyChildren = Array.from(document.body.children);

  bodyChildren.forEach((child) => {
    const isExcluded =
      child === openedElement ||
      excludedSelectors.some((selector) => child.matches(selector));

    if (isExcluded) return;

    toggleInert(child, shouldInert);
  });
};
