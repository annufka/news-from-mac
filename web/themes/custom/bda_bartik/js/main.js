import {MyComponent} from "./Components/MyComponent";
import {TableComponent} from "./Components/TableComponent";
// const root = ReactDOM.createRoot(document.getElementById('react-root-id'));
// root.render(<MyComponent/>)

(function ($, Drupal) {
  Drupal.behaviors.customElement = {
    attach: function (context, settings) {
      $('#react-root-id, .custom-react-list', context).each(function () {
        const root = ReactDOM.createRoot($(this)[0]);
        // root.render(<MyComponent/>);
        root.render(<TableComponent/>);
      });
    }
  }
})(jQuery, Drupal)
