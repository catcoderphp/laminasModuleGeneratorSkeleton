
#Creating Controller
echo "Creating $2Controller..."
touch module/Application/src/Controller/$2Controller.php
cp -r module/Application/src/Controller/BaseController.php module/Application/src/Controller/$2Controller.php
sed -i -e "s/Base/$2/" module/Application/src/Controller/$2Controller.php

#Creating Factory
echo "Creating $2ControllerFactory"
touch module/Application/src/Factory/Controller/$2ControllerFactory.php
cp -r module/Application/src/Factory/Controller/BaseControllerFactory.php module/Application/src/Factory/Controller/$2ControllerFactory.php
sed -i -e "s/Base/$2/" module/Application/src/Factory/Controller/$2ControllerFactory.php

#Creating Mapper

echo "Creating $2Mapper"
touch module/Application/src/Mapper/$2Mapper.php
cp -r module/Application/src/Mapper/BaseMapper.php module/Application/src/Mapper/$2Mapper.php
sed -i -e "s/Base/$2/" module/Application/src/Mapper/$2Mapper.php

#Creating Mapper Factory
echo "Creating $2MapperFactory"
touch module/Application/src/Factory/Mapper/$2MapperFactory.php
cp -r module/Application/src/Factory/Mapper/BaseMapperFactory.php module/Application/src/Factory/Mapper/$2MapperFactory.php
sed -i -e "s/Base/$2/" module/Application/src/Factory/Mapper/$2MapperFactory.php

#creating Service
echo "Creating $2Service"
touch module/Application/src/Service/$2Service.php
cp -r module/Application/src/Service/BaseService.php module/Application/src/Service/$2Service.php
sed -i -e "s/Base/$2/" module/Application/src/Service/$2Service.php

#creating Service Factory
echo "Creating $2ServiceFactory"
touch module/Application/src/Factory/Service/$2ServiceFactory.php
cp -r module/Application/src/Factory/Service/BaseServiceFactory.php module/Application/src/Factory/Service/$2ServiceFactory.php
sed -i -e "s/Base/$2/" module/Application/src/Factory/Service/$2ServiceFactory.php


#creating Dao
echo "Creating $2Dao"
touch module/Application/src/Dao/$2Dao.php
cp -r module/Application/src/Dao/BaseDao.php module/Application/src/Dao/$2Dao.php
sed -i -e "s/Base/$2/" module/Application/src/Dao/$2Dao.php

#creating Service Factory
echo "Creating $2DaoFactory"
touch module/Application/src/Factory/Dao/$2DaoFactory.php
cp -r module/Application/src/Factory/Dao/BaseDaoFactory.php module/Application/src/Factory/Dao/$2DaoFactory.php
sed -i -e "s/Base/$2/" module/Application/src/Factory/Dao/$2DaoFactory.php

sed -i -e "/\$service_manager =/s/$/ \n 'Application\\\Mapper\\\\$2Mapper' => 'Application\\\Factory\\\Mapper\\\\$2MapperFactory',/" module/Application/src/Factories.php

sed -i -e "/\$service_manager =/s/$/ \n 'Application\\\Service\\\\$2Service' => 'Application\\\Factory\\\Service\\\\$2ServiceFactory',/" module/Application/src/Factories.php

sed -i -e "/\$service_manager =/s/$/ \n 'Application\\\Dao\\\\$2Dao' => 'Application\\\Factory\\\Dao\\\\$2DaoFactory',/" module/Application/src/Factories.php

sed -i -e "/\$controllers =/s/$/ \n 'Application\\\Controller\\\\$2' => 'Application\\\Factory\\\Controller\\\\$2ControllerFactory',/" module/Application/src/Factories.php

sed -i -e "/\$service_manager =/s/$/ \n \/\/$2 Configuration/" module/Application/src/Factories.php
