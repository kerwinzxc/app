<?php

$ke_shi = array(
                "10" => array("name" => "内科",
                              "sub"  => array("10" => array("name" => "消化内科",
                                                            "sub" => array("10" => array("name" => "胃病"),
                                                                           "11" => array("name" => "肠炎"),
                                                                           "12" => array("name" => "肝疼"),
                                                                          )
                                                           ),
                                              "11" => array("name" => "神经内科",
                                                            "sub" => array("10" => array("name" => "头疼"),
                                                                           "11" => array("name" => "这疼"),
                                                                          )
                                                           )
                                              )
                              ),
                "11" => array("name" => "外科",
                              "sub"  => array("10" => array("name" => "消化内科",
                                                            "sub" => array("10" => array("name" => "胃病"),
                                                                           "11" => array("name" => "肠炎"),
                                                                           "12" => array("name" => "肝疼"),
                                                                          )
                                                           ),
                                              "11" => array("name" => "神经内科",
                                                            "sub" => array("10" => array("name" => "头疼"),
                                                                           "11" => array("name" => "这疼"),
                                                                          )
                                                           )
                                              )
                              )
                );
printf("%s\n", json_encode($ke_shi));
