<?xml version="1.0" encoding="UTF-8"?>
                <?adf version="1.0"?>
                    <adf>
                    <prospect>
                       <requestdate>{{ date("Y-d-m H:i:s")}}</requestdate>
                       <vehicle>
                            <id></id>
                            <year></year>
                            <make>{{ $data->product_of_interest }}</make>
                            <model>{{ $data->product_of_interest }}</model>
                            <vin></vin>
                            <stock></stock>
                            <trim></trim>
                            <price type="asking"></price>
                        </vehicle>
                        <customer>
                            <contact>
                                <name part="full">{{ $data->name }}</name>
                                <email>@if ($data->contact_method == 'email'){{ $data->contact_value }}@endif</email>
                                <phone>{{ $data->contact_value }}</phone>
                                <cellphone>{{ $data->contact_value }}</cellphone>
                                <international_phone></international_phone>
                                <address>
                                    <street></street>
                                    <city></city>
                                    <regioncode></regioncode>
                                    <postalcode></postalcode>
                                    <country>Paraguay</country>
                                </address>
                            </contact>
                            <comments>
                                    <![CDATA[" 
                                    
                                    @if ($data->contact_method == 'phone')
                                        Teléfono: {{ $data->contact_value }}
                                    @elseif ($data->contact_method == 'email')
                                        Email: {{ $data->contact_value }}
                                    @elseif ($data->contact_method == 'whatsapp')
                                        Whatsapp: {{ $data->contact_value }}
                                    @endif
                                        <br>
                                    @if ($data->message != null && strlen($data->message) > 0)
                                        Con el siguiente mensaje:
                                        {{ $data->message }}
                                    @endif
                                    "]]>
                              </comments>
                        </customer>
                        <vendor>
                            <vendorname></vendorname>
                            <contact>
                                <name part="full"></name>
                                <email></email>
                                <phone></phone>
                            </contact>
                        </vendor>
                        <provider>
                            <name></name>
                            <service></service>
                            <notification_email></notification_email >
                            <debug>0</debug >
                            <url><![CDATA["asd"]]></url>
                        </provider>
                    </prospect>
                    <format>
                        <formtype>pilot</formtype>
                        <formversion>1</formversion>
                        <key>1898F9EE-D769-4CF5-AEBD-17A11BC04E62</key>
                    </format>
                </adf>