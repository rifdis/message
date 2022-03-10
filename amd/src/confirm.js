// Standard license block omitted.
/*
 * @module     local_message/confirm
 * @copyright  2022 Someone cool
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


define(['jquery', 'core/modal_factory','core/str','core/modal_events','core/ajax','core/notification'],
function($, ModalFactory,String,ModalEvents,Ajax,Notification) {
    var trigger = $('.local_message_delete_button');
    ModalFactory.create({
      type: ModalFactory.types.SAVE_CANCEL,
      title: String.get_string('delete_message','local_message'),
      body: String.get_string('delete_message_confirm','local_message'),
      preShowCallback: (triggerElement,modal) =>{
          var triggerElement = $(triggerElement[0]);
          let message_id = triggerElement.data('id');
          modal.params = {'message_id':message_id};
          modal.setSaveButtonText(String.get_string('delete_message','local_message'));
      }
    }, trigger)
    .done(function(modal) {
      // Do what you want with your new modal.
      modal.getRoot().on(ModalEvents.save, (e) =>{
          e.preventDefault();

          Y.log(modal.params);

          let request = {
              methodname: 'local_message_delete_message',
              args:modal.params
          };

          let footer = Y.one('.modal-footer');
          footer.setContent('Deleting...');
          let spinner = M.util.add_spinner(Y,footer);
          spinner.show();
          Ajax.call([request])[0].done((data) => {
              //spinner.hide();
              if(data === true){
                window.location.reload();
              }
              else{
                  Notification.addNotification({
                      message: String.get_string('error_deleting_message','local_message'),
                      type: 'error'
                  });
              }
          }).fail(Notification.exception);

      });
    });
  });