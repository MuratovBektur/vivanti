# build new container for build vue app
docker build  -f Dockerfile -t jcat_build_client .  || true;
# run container
docker run --name JCatBuildClient -itd jcat_build_client;
# copy from container's dist folder to local dist foler
docker cp JCatBuildClient:/app/dist .
# remove container after using;
docker container rm -f JCatBuildClient;
# remove image after using;
docker rmi -f jcat_build_client;
