                        var group = $("ol.limited_drop_targets").sortable({
                          group: 'limited_drop_targets',
                          isValidTarget: function  (item, container) {
                                if(item.is(".course"))
                                  return true
                                else {
                                  return item.parent("ol")[0] == container.el[0]
                                }
                          },
                          onDrop: function (item, container, _super) {
                    //        $('#serialize_output').text(group.sortable("serialize").get().join("|"))
                            _super(item, container)
                          },
                          serialize: function (parent, children, isContainer) {
                            return isContainer ? children.join() : parent.text()
                          }
                        })
                        var group2 = $("ol.simple_with_drop").sortable({
                          group: 'simple_with_drop',
                                isValidTarget: function  (item, container) {
                                if(item.is(".time"))
                                  return true
                                else {
                                  return item.parent("ol")[0] == container.el[0]
                                }
                          },
                          onDrop: function (item, container, _super) {
                   //         $('#serialize_output2').text(group2.sortable("serialize").get().join("|"))
                            _super(item, container)
                          },
                          serialize: function (parent, children, isContainer) {
                            return isContainer ? children.join() : parent.text()
                          }
                        })
                  function getSerialized()
                  {
                    $('#serialize_output2').text(group2.sortable("serialize").get().join("|"))
                    $('#serialize_output').text(group.sortable("serialize").get().join("|"))
                    var string1 = document.getElementById("serialize_output").innerHTML;
                    var string2 = document.getElementById("serialize_output2").innerHTML;
                    var serial1 = document.getElementById("serial1");
                    var serial2 = document.getElementById("serial2");
                    serial1.value = string1;
                    serial2.value = string2;
//                    alert(string1); alert(string2);
                  }

