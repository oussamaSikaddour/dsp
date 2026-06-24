import { positionRelativeTo } from "../../utils/positioning";
import { on } from "../../utils/DespatchCustomEvent";

const getSharedContainer = () =>
  document.querySelector(".combobox__table__container");

const ComboboxTable = () => {
  const container = getSharedContainer();
  if (!container) return;

  let trigger = null;
  let triggerId = null;
  let cleanupPosition = null;
  let isOpen = false;
  let justOpened = false;


  const applyPanelPosition = () => {
    if (!trigger) return;

    if (cleanupPosition) {
      cleanupPosition();
      cleanupPosition = null;
    }


    cleanupPosition = positionRelativeTo(trigger, container, -51);
  };

  const focusSearchInput = () => {
    requestAnimationFrame(() => {
      const searchInput = container.querySelector(".combobox-search-input");
      if (searchInput) {
        searchInput.focus();
      }
    });
  };

  const open = (newTrigger, htmlId = null) => {
    if (!newTrigger) return;

    if (trigger && trigger !== newTrigger) {
      trigger.setAttribute("aria-expanded", "false");
    }

    trigger = newTrigger;
    triggerId = htmlId || newTrigger.id || null;

    container.classList.add("show");
    container.removeAttribute("aria-hidden");
    container.removeAttribute("inert");

    applyPanelPosition();

    trigger.setAttribute("aria-expanded", "true");
    isOpen = true;

    justOpened = true;
    setTimeout(() => {
      justOpened = false;
    }, 0);

    focusSearchInput();
  };

  const close = () => {
    if (!isOpen) return;

    if (container.contains(document.activeElement) && trigger) {
      trigger.focus();
    }

    container.classList.remove("show");
    container.setAttribute("aria-hidden", "true");

    if (cleanupPosition) {
      cleanupPosition();
      cleanupPosition = null;
    }

    if (trigger) {
      trigger.setAttribute("aria-expanded", "false");
    }

    trigger = null;
    triggerId = null;
    isOpen = false;
  };

  const updatePosition = () => {
    if (!isOpen) return;

    if (triggerId) {
      const currentTrigger = document.getElementById(triggerId);
      if (currentTrigger) {
        trigger = currentTrigger;
      }
    }

    applyPanelPosition();
  };

  on("combobox-table:show", (detail) => {
    const htmlId = detail?.htmlId;
    if (!htmlId) return;

    const newTrigger = document.getElementById(htmlId);
    if (!newTrigger) return;

    open(newTrigger, htmlId);

    requestAnimationFrame(() => {
      updatePosition();
    });
  });

  on("combobox-table:close", () => {
    close();
  });

  document.addEventListener("click", (event) => {
    if (!isOpen) return;
    if (justOpened) return;

    const target = event.target;

    const clickedInsideContainer = container.contains(target);
    const clickedTriggerByNode = trigger?.contains(target);

    const clickedTriggerById =
      triggerId &&
      target instanceof Element &&
      !!target.closest(`#${CSS.escape(triggerId)}`);

    if (!clickedInsideContainer && !clickedTriggerByNode && !clickedTriggerById) {
      close();
    }
  });

  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") {
      close();
    }
  });

  window.addEventListener("resize", updatePosition);
  window.addEventListener("scroll", updatePosition, { passive: true });
};

export default ComboboxTable;
